<?php

namespace ndef;

class message extends ndefTools
{
    private $encoded = [];
    private $ndefRecords = [];
    private $tnf_byte;
    private $type_length;
    private $payload_length;
    private $id_length;
    private $i;

    public function setNDEFRecords(array $ndefRecords)
    {
        if (!is_array($ndefRecords) || count($ndefRecords) == 0) {
            throw new \Exception("Expects: Array of NDEF Records");
        }

        //Check to see that we actually have an array of records
        foreach ($ndefRecords as $record) {
            if (!$record instanceof record) throw new \Exception("Expects: Array elements must be of Record Type");
        }

        $this->ndefRecords = $ndefRecords;
        return true;
    }

    public function encodeMessage()
    {
        if (count($this->ndefRecords) == 0) {
            throw new \Exception("No records to encode!");
        }
        foreach ($this->ndefRecords as $key => $record) {
            $tnf = new tnf();
            $tnf->setTNF($record->getTNF())
                ->setIndex($key)
                ->setRecord($record)
                ->setRecords($this->ndefRecords);
            $this->pushData($tnf->buildTNF());
        }
    }

    public function decodeMessage()
    {
        //TO DO
    }

    public function getEncodedMessage()
    {
        return $this->encoded;
    }

    private function pushData($data)
    {
        //array_push($this->encoded,$data);
        $this->encoded = array_merge($this->encoded, $data);
        return true;
    }
}