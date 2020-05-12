<?php

namespace ndef;

class ndefTools extends ndefData
{
    public function stringToBytes($str)
    {
        return unpack('C*', $str);
    }

    public function bytesToString($bytes)
    {
        $returnString = '';
        foreach ($bytes as $byte) $returnString .= ord($byte);
        return $returnString;
    }

    public function hexStringToBytes($str)
    {
        $returnArray = [];
        $str = str_split($str, 2);
        foreach ($str as $b) $returnArray[] = hexdec($b);
        return $returnArray;
    }

    public function bytesToHexString($bytes)
    {
        $returnString = '';
        foreach ($bytes as $byte) $returnString .= sprintf("%02X", $byte);
        return $returnString;
    }
}
