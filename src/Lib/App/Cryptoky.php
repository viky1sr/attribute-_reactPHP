<?php

namespace Jamkrindo\Lib\App;

use Jamkrindo\Lib\Traits\CryptokyTrait;
use Psr\Http\Message\ServerRequestInterface;

class Cryptoky
{
    use CryptokyTrait;

    public static function encrypt( String $input, String $uniqueString,bool $binary = false) : String
    {
        $encrypted = '';
        $inputLength = strlen($input);
        $uniqueLength = strlen($uniqueString);
        for ($i = 0; $i < $inputLength; $i++) {
            $char = $input[$i];
            $uniqueChar = $uniqueString[$i % $uniqueLength];
            $encryptedChar = ord($char) + ord($uniqueChar);
            $encrypted .= chr($encryptedChar);
        }
        $string = $encrypted;
        $arrCode = (new self)->divideAndGetRemainder($string,7,false);
        $combineString = (new self)->combineString($arrCode);
        $result = ($binary ? $combineString : base64_encode(bin2hex($combineString)));
        return $result;
    }

    public static function decrypt(String $input, String $uniqueString,bool $binary = false) : String
    {
        $decodeString = ($binary) ? $input : hex2bin(base64_decode($input));
        $input = (new self)->combineString($decodeString,false);
        $decrypted = '';
        $inputLength = strlen($input);
        $uniqueLength = strlen($uniqueString);
        for ($i = 0; $i < $inputLength; $i++) {
            $char = $input[$i];
            $uniqueChar = $uniqueString[$i % $uniqueLength];
            $decryptedChar = ord($char) - ord($uniqueChar);
            $decrypted .= chr($decryptedChar);
        }
        return $decrypted;
    }

    public static function createJWT($payload, $key) : String
    {
        try {
            $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256'], JSON_THROW_ON_ERROR);
            $header = (new self)->base64UrlEncode($header);
            $payload = (new self)->base64UrlEncode(json_encode($payload, JSON_THROW_ON_ERROR));
            $signature = hash_hmac('sha256', "$header.$payload", $key, true);
            $signature = (new self)->base64UrlEncode($signature);
            return "$header.$payload.$signature";
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function generateUniqueKeyToBinHex(ServerRequestInterface $request) : String
    {
        $ip = $request->getServerParams();
        $toArray = explode('.', (string)$ip);
        $len = count($toArray);
        $key = env("KEY_SECRET","~!@#$%^&*()_+-=1234567890qWeRtY");
        $getPola = (new self)->divideAndGetRemainder($key,$len);
        $privateKey = "";
        foreach ($toArray as $k => $v) {
            $privateKey .= ($k === 0) ? $getPola[$k].$v : $v.$getPola[$k];
        }
        $resultUri = (new self)->combineString((new self)->divideAndGetRemainder($privateKey,7));
        $newString = (new self)->divideAndGetRemainder($resultUri. $request->getBody()->__toString(),7);
        return (new self)->combineString($newString);
    }

    public static function getPayloadFromJWT(String $jwt, ServerRequestInterface $request): string
    {
        [, $payload,] = explode('.', $jwt);
        $key = self::generateUniqueKeyToBinHex($request);
        $input =  (new self)->base64UrlDecode($payload);
        return self::decrypt($input,$key);
    }
}
