<?php

namespace Jamkrindo\Lib\Traits;

trait CryptokyTrait
{
    protected function base64UrlDecode($data) : String
    {
        $url = strtr($data, '-_', '+/');
        $padded = str_pad($url, strlen($data) % 4, '=', STR_PAD_RIGHT);
        return base64_decode($padded);
    }

    protected function divideAndGetRemainder($string, $numParts,$type = true) : array
    {
        $totalLength = strlen($string);
        $partLength = floor($totalLength / $numParts);
        $remainder = $totalLength % $numParts;
        $parts = [];
        $startIndex = 0;

        for ($i = 0; $i < $numParts; $i++) {
            if($type) {
                $addLength = ($remainder !== 0 && $i === 0) ? $remainder : 0;
            } else {
                $addLength = ($remainder !== 0 && ($numParts - 1) === $i ? $remainder : 0);
            }
            $length = $partLength + $addLength;
            $parts[] = substr($string, $startIndex, $length);

            $startIndex += $length;
        }
        return $parts;
    }

    /*
     * type = [true: encode, false: decode ]
     * $resultArray = [true: array, false: string]
     * $this->divideAndGetRemainder ( string , numParts = 7 [ ada 7 array ]
     */
    protected function combineString($resultArray,$type = true) : String
    {
        $order = $type ? [6, 0, 5, 3, 1, 4, 2] :  [1, 4, 6, 3, 5, 2, 0];
        $resultArray = $type ? $resultArray : $this->divideAndGetRemainder($resultArray,7);
        $combinedString = "";
        foreach ($order as $index) {
            $combinedString .= $resultArray[$index];
        }
        return $combinedString;
    }

    protected function base64UrlEncode($data)
    {
        if($base64 = base64_encode($data)) {
            $url = strtr($base64, '+/', '-_');
            return rtrim($url, '=');
        }
        return false;
    }
}
