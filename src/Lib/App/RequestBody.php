<?php

namespace Jamkrindo\Lib\App;

use Psr\Http\Message\ServerRequestInterface;

class RequestBody
{

    public function __construct(protected ServerRequestInterface $request){}


    private static  function logicConvert(string $jsonString , array $fields = []) : array
    {
        $result = [];
        foreach ($fields as $field) {
            $startPosition = strpos($jsonString, "\"$field\":");

            if ($startPosition !== false) {
                $startPosition += strlen("\"$field\":");
                if($jsonString[$startPosition] === '{') {
                    $endPosition = strpos($jsonString, '}', $startPosition) + 1;
                } else {
                    $endPosition = strpos($jsonString, ',', $startPosition);
                }
                if ($endPosition === false) {
                    $endPosition = strlen($jsonString) - 1;
                }
                $value = substr($jsonString, $startPosition, $endPosition - $startPosition);
                $value = trim($value, " \t\n\r\0\x0B\"");
                $result[$field] = ($value === 'null') ? null : $value;
            } else {
                $result[$field] = null;
            }
        }
        return $result;
    }

    public static function extractValue(string $jsonString, string $key): array
    {
        $keyParts = explode('.', $key);
        $maxKey = count($keyParts);
        if($maxKey === 1) {
            $keyPartWithQuotes = $keyParts[0];
            $decodeString = json_decode($jsonString);
            $data = property_exists($decodeString,$keyPartWithQuotes) ? $decodeString->$keyPartWithQuotes : null;
            return [
                $keyPartWithQuotes => $data
            ];
        } else {
            $data = self::logicConvert($jsonString,[$keyParts[0]]);
            $tamps = [
                $keyParts[0] => []
            ];
            for($i = 1; $i < $maxKey; $i++) {
                $tamps[$keyParts[0]] =  self::logicConvert($data[$keyParts[0]],[$keyParts[$i]]);
            }
            return $tamps;
        }
    }

    public static function getAsArray(string $jsonString , array $fields = []) : array
    {
        return self::logicConvert($jsonString,$fields);
    }

    public function fillable(array $fields = []) : array | false
    {
        $jsonString = $this->request->getBody()->__toString();
        return self::logicConvert($jsonString,$fields);
    }

    public  function getBody() : String
    {
        var_dump($this->request);die;
        return $this->request->getBody()->__toString();
    }

    public  function getBodyArray() : array
    {
        return json_decode($this->request->getBody()->__toString(),true);
    }

    public  function getBodyJson() : object
    {
        return json_decode($this->request->getBody()->__toString(),false);
    }
}
