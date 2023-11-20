<?php

namespace Jamkrindo\Lib;

use PDO;
use PDOStatement;
use React\EventLoop\Factory;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;

class DB
{
    private static string $queryString;
    private static array $bindings = [];
    private static ?PDO $pdo = null;

    private static function pdoType($type): int
    {
        return match ($type) {
            'integer' => PDO::PARAM_INT,
            'boolean' => PDO::PARAM_BOOL,
            'NULL' => PDO::PARAM_NULL,
            default => PDO::PARAM_STR,
        };
    }

    public static function close(): void
    {
        if (isset(self::$pdo)) {
            self::$pdo = null;
        }
    }

    public static function query(string $query, array $bindings = []): self
    {
        self::$queryString = $query;
        self::$bindings = $bindings;
        return new self();
    }

    public static function connection(): PDO
    {
        if (!isset(self::$pdo)) {
            $dsn = 'sqlsrv:server='.env('DB_HOST').';Database='.env('DB_DATABASE');
            self::$pdo = new PDO($dsn,  env("DB_USERNAME"), env("DB_PASSWORD"));
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
    }

    private function fetchData(): false|PDOStatement
    {
        $result = self::connection()->prepare(self::$queryString);

        if (!empty(self::$bindings)) {
            foreach (self::$bindings as $key => $binding) {
                $param = is_string($key) ? $key : $key + 1;
                $type = self::pdoType(gettype($binding));
                $result->bindValue($param, $binding, $type);
            }
        }

        $result->execute();

        return $result;
    }

    public function get(): array|false
    {
        return $this->fetchData()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function firstRow(): object|false|null
    {
        return $this->fetchData()->fetchObject();
    }

    public static function insert(array $data, string $table): PromiseInterface
    {
        $loop = Factory::create();
        $deferred = new Deferred();

        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        self::$queryString = $query;
        self::$bindings = $data;

        $statement = self::connection()->prepare(self::$queryString);

        foreach (self::$bindings as $key => $binding) {
            $statement->bindValue(':' . $key, $binding);
        }

        $loop->addTimer(0.001, function () use ($deferred, $statement) {
            try {
                $statement->execute();
                $rowCount = $statement->rowCount();
                self::close();
                $deferred->resolve($rowCount);
            } catch (\Exception $exception) {
                self::close();
                $deferred->reject($exception);
            }
        });

        $loop->run();

        return \React\Promise\resolve($deferred->promise());
    }

    public static function update(array $data, string $table, string $condition): PromiseInterface
    {
        $loop = Factory::create();
        $deferred = new Deferred();

        $setClause = implode(', ', array_map(fn($key) => "$key = ?", array_keys($data)));
        $query = "UPDATE $table SET $setClause WHERE $condition";

        self::$queryString = $query;
        self::$bindings = array_values($data);

        $statement = self::connection()->prepare(self::$queryString);
        foreach (self::$bindings as $key => $binding) {
            $statement->bindValue(':' . $key, $binding);
        }

        $loop->addTimer(0.001, function () use ($deferred, $statement) {
            try {
                $statement->execute();
                $rowCount = $statement->rowCount();
                self::close();
                $deferred->resolve($rowCount);
            } catch (\Exception $exception) {
                self::close();
                $deferred->reject($exception);
            }
        });

        $loop->run();

        return \React\Promise\resolve($deferred->promise());
    }
}
