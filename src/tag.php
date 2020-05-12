<?php

namespace ndef;

class tag extends ndefTools
{
    private $encoded;

    public function addEncoded($encoded)
    {
        $this->encoded = $encoded;
        return $this;
    }

    public function encodeTag()
    {
        array_unshift($this->encoded, count($this->encoded));
        array_unshift($this->encoded, $this->TLV_NDEF);
        array_push($this->encoded, $this->TLV_TERMINATOR);
        return true;
    }

    public function getEncodedTag()
    {
        return $this->encoded;
    }
}