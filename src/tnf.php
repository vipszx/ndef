<?php

namespace ndef;

class tnf extends ndefTools
{
    private $mb;
    private $me;
    private $cf = FALSE;
    private $sr;
    private $il;
    private $tnf;
    private $record = FALSE;
    private $records = FALSE;
    private $recordsLength;
    private $index = 0;
    private $result = [];

    public function setIndex($index)
    {
        $this->index = $index;
        $this->record = $this->records[$index];
        return $this;
    }

    public function setRecords(array $records)
    {
        //Check to see that we actually have an array of records
        foreach ($records as $record) {
            if (!$record instanceof record) {
                throw new \Exception("Expects: Array elements must be of Record Type");
            }
        }

        $this->records = $records;
        $this->recordsLength = count($this->records);
        return $this;
    }

    public function setRecord(record $record)
    {
        $this->record = $record;
        return $this;
    }

    public function setTNF($tnf)
    {
        $this->tnf = $tnf;
        return $this;
    }

    public function getRecordsLength()
    {
        return $this->recordsLength;
    }

    private function getTNF()
    {
        if (!$this->record) throw new \Exception("Record must be set and of type record");

        $this->mb = ($this->index === 0);
        $this->me = ($this->index === ($this->getRecordsLength() - 1));
        $this->sr = ($this->record->getPayloadSize() < 0xFF);
        $this->il = (count($this->record->getId()) > 0);

        if ($this->mb) {
            $this->tnf = $this->tnf | 0x80;
        }
        if ($this->me) {
            $this->tnf = $this->tnf | 0x40;
        }
        if ($this->cf) {
            $this->tnf = $this->tnf | 0x20;
        }
        if ($this->sr) {
            $this->tnf = $this->tnf | 0x10;
        }
        if ($this->il) {
            $this->tnf = $this->tnf | 0x8;
        }

        return $this->tnf;
    }

    public function buildTNF()
    {
        $this->result[] = $this->getTNF();

        $this->result[] = $this->record->getTypeLength();

        if ($this->sr) {
            $this->result[] = $this->record->getPayloadSize();
        } else {
            $this->result[] = $this->record->getPayloadSize() >> 24;
            $this->result[] = $this->record->getPayloadSize() >> 16;
            $this->result[] = $this->record->getPayloadSize() >> 8;
            $this->result[] = $this->record->getPayloadSize() & 0xFF;
        }

        if ($this->il) {
            $this->result[] = count($this->record->getId());
        }

        $this->result = array_merge($this->result, $this->record->getType());

        if ($this->il) {
            $this->result[] = $this->record->getId();
        }

        $this->result = array_merge($this->result, $this->record->getPayload());

        return $this->result;
    }
}