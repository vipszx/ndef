<?php

namespace ndef;

class record extends ndefTools
{
    private $tnf;
    private $type;
    private $id = [];
    private $payload = [];

    public function getTNF()
    {
        return $this->tnf;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    public function getPayloadSize()
    {
        return count($this->payload);
    }

    public function getTypeLength()
    {
        return count($this->type);
    }

    public function setType($type = null)
    {
        if (!is_array($type) && strlen($type) != 0) {
            $this->type = $this->stringToBytes($type);
        } else {
            if (!is_null($type)) {
                $this->type = $type;
            } else {
                $this->type = [];
            }

        }
        return $this;
    }

    public function setTNF($tnf)
    {
        $this->tnf = $tnf;
        return $this;
    }

    public function setId(array $id)
    {
        $this->id = $id;
        return $this;
    }

    public function setPayload(array $payload)
    {
        $this->payload = $payload;
        return $this;
    }

}