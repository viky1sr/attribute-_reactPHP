<?php

namespace Jamkrindo\Lib\App;

use DateInterval;
use DateTime;
use RuntimeException;

class FileCache
{
    private $storagePath = __DIR__ . '/../../../storage/cache/';

    public function __construct()
    {
        if (!is_dir($this->storagePath)) {
            if (!mkdir($concurrentDirectory = $this->storagePath, 0777, true) && !is_dir($concurrentDirectory)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        }
    }

    private function ExpirationDateTime(int $ttl): DateTime
    {
        $currentDateTime = new DateTime();
        $expirationDateTime = clone $currentDateTime;
        return $expirationDateTime->add(new DateInterval('PT' . $ttl . 'S'));
    }

    public function get($key): bool|string|null
    {
        $filePath = $this->getFilePath($key);
        $this->scheduleExpiration($filePath);

        if (file_exists($filePath)) {
            $stringJson = Cryptoky::decrypt(file_get_contents($filePath),env("KEY_SECRET"),true);
            $data = json_decode($stringJson, true);
            return $data['Data'];
        }
        return null;
    }

    public function set($key, $value, $ttl = 0): bool
    {
        $directoryPath = $this->storagePath . md5($key);

        if (!is_dir($directoryPath)) {
            if (!mkdir($directoryPath, 0777, true) && !is_dir($directoryPath)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $directoryPath));
            }
        }

        $filePath = $this->getFilePath($key);
        $cacheData = [
            'ExpirationDateTime' => ($ttl != 0) ?  $this->ExpirationDateTime($ttl) : false,
            'Data' => $value
        ];
        if(file_exists($filePath)) {
            $cacheData = array_merge($cacheData, ['ExpirationDateTime' => $this->getCacheTime($filePath)['ExpirationDateTime']]);
        }
        $encryptData = Cryptoky::encrypt(json_encode($cacheData),env("KEY_SECRET"),true);
        file_put_contents($filePath, $encryptData);
        return true;
    }


    private function getFilePath($key): string
    {
        return $this->storagePath . md5($key).'/data.cache';
    }

    private function getCacheTime($filePath): array
    {
        $stringJson = Cryptoky::decrypt(file_get_contents($filePath),env("KEY_SECRET"),true);
        return RequestBody::extractValue($stringJson,'ExpirationDateTime.date');
    }

    private function scheduleExpiration($filePath): void
    {
        if (file_exists($filePath)) {
            $data = $this->getCacheTime($filePath);
            if($data['ExpirationDateTime']['date'] <= date('Y-m-d H:i:s')){
                unlink($filePath);
            }
        }

    }

}
