<?php

namespace ndef;

class ndef extends ndefTools
{
    private $encodedMessage;

    /**
     * Creates a JSON representation of a NDEF Record.
     *
     * @tnf 3-bit TNF (Type Name Format) - use one of the TNF_* constants
     * @type byte array, containing zero to 255 bytes, must not be null
     * @id byte array, containing zero to 255 bytes, must not be null
     * @payload byte array, containing zero to (2 ** 32 - 1) bytes, must not be null
     *
     * @returns JSON representation of a NDEF record
     *
     * @see Ndef.textRecord, Ndef.uriRecord and Ndef.mimeMediaRecord for examples
     */
    public function record($tnf = null, $type = [], $id = [], $payload = [])
    {

        if (!is_array($type) && count($type) != 0) {
            $type = $this->stringToBytes($type);
        }
        if (!is_array($id) && count($id) != 0) {
            $id = $this->stringToBytes($id);
        }
        if (!is_array($payload) && count($payload) != 0) {
            $payload = $this->stringToBytes($payload);
        }

        $returnArray['tnf'] = $tnf;
        $returnArray['type'] = $type;
        $returnArray['id'] = $id;
        $returnArray['payload'] = $payload;

        return $returnArray;
    }

    /**
     * Helper that creates an NDEF record containing plain text.
     *
     * @text String of text to encode
     * @languageCode ISO/IANA language code. Examples: �fi�, �en-US�, �fr- CA�, �jp�. (optional)
     * @id byte[] (optional)
     */
    public function textRecord($text = null, $languageCode = "en", $id = [])
    {
        $payload = [];

        $payload[] = strlen($languageCode);
        $payload = array_merge($payload, $this->stringToBytes($text));

        $record = new record();
        $record->setTNF($this->TNF_WELL_KNOWN)
            ->setType($this->RTD_TEXT)
            ->setId($id)
            ->setPayload($payload);

        return $record;
    }

    /**
     * Helper that creates a NDEF record containing a URI.
     *
     * @uri String
     * @id byte[] (optional)
     */
    public function uriRecord($uri, $id = [])
    {
        $payload = [];
        $found = FALSE;
        foreach ($this->RTD_URI_TYPES as $val => $type) {
            if (!is_null($type) && strpos($uri, $type) !== false) {
                $payload[] = dechex($val);

                $uri = str_replace($type, '', $uri);
                $found = TRUE;
                break;
            }
        }

        if ($found === FALSE) $payload[] = 0x0;

        $payload = array_merge($payload, $this->stringToBytes($uri));

        $record = new record();
        $record->setTNF($this->TNF_WELL_KNOWN)
            ->setType($this->RTD_URI)
            ->setId($id)
            ->setPayload($payload);

        return $record;
    }

    public function unknownRecord($hexData, $id = [])
    {
        //We're accepting the data as a string of hex.
        //We need to change this into an array of byte values
        $payload = $this->hexStringToBytes($hexData);

        $record = new record();
        $record->setTNF($this->TNF_UNKNOWN)
            ->setType()
            ->setId($id)
            ->setPayload($payload);

        return $record;
    }

    /**
     * Helper that creates a NDEF record containing an absolute URI.
     *
     * @text String
     * @id byte[] (optional)
     */
    public function absoluteUriRecord($text, $id = [])
    {
        $record = new record();
        $record->setTNF($this->TNF_ABSOLUTE_URI)
            ->setType($this->hexStringToBytes($text))
            ->setId($id)
            ->setPayload([]);

        return $record;
    }

    /**
     * Helper that creates a NDEF record containing an mimeMediaRecord.
     *
     * @mimeType String
     * @payload byte[]
     * @id byte[] (optional)
     */
    public function mimeMediaRecord($mimeType, $payload = [], $id = [])
    {
        $record = new record();
        $record->setTNF($this->TNF_MIME_MEDIA)
            ->setType($this->stringToBytes($mimeType))
            ->setId($id)
            ->setPayload($payload);

        return $record;
    }

    public function emptyRecord()
    {
        $record = new record();
        $record->setTNF($this->TNF_EMPTY)
            ->setType([])
            ->setId([])
            ->setPayload([]);

        return $record;
    }

    public function getEncodedMessage()
    {
        return $this->encodedMessage;
    }

    public function encodeMessage(array $ndefRecords)
    {
        $message = new message();
        $message->setNDEFRecords($ndefRecords);
        $message->encodeMessage();
        $this->encodedMessage = $message->getEncodedMessage();
        return true;
    }

}