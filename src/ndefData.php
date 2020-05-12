<?php

namespace ndef;

class ndefData
{
    public $TNF_EMPTY = 0x0;
    public $TNF_WELL_KNOWN = 0x01;
    public $TNF_MIME_MEDIA = 0x02;
    public $TNF_ABSOLUTE_URI = 0x03;
    public $TNF_EXTERNAL_TYPE = 0x04;
    public $TNF_UNKNOWN = 0x05;
    public $TNF_UNCHANGED = 0x06;
    public $TNF_RESERVED = 0x07;

    public $RTD_TEXT = [0x54];
    public $RTD_URI = [0x55];
    public $RTD_URI_TYPES = [null, 'http://www', 'https://www.', 'http://', 'https://',
        'tel:', 'mailto:', 'ftp://anonymous:anonymous@', 'ftp://ftp.',
        'ftps://', 'sftp://', 'smb://', 'nfs://', 'ftp://', 'dav://',
        'news:', 'telnet://', 'imap:', 'rtsp://', 'urn:', 'pop:', 'sip:',
        'sips:', 'tftp:', 'btspp://', 'btl2cap://', 'btgoep://', 'tcpobex://',
        'irdaobex://', 'file://', 'urn:epc:id:', 'urn:epc:tag:', 'urn:epc:pat:',
        'urn:epc:raw:', 'urn:epc:', 'urn:nfc:'];
    public $RTD_SMART_POSTER = [0x53, 0x70];
    public $RTD_ALTERNATIVE_CARRIER = [0x61, 0x63];
    public $RTD_HANDOVER_CARRIER = [0x48, 0x63];
    public $RTD_HANDOVER_REQUEST = [0x48, 0x72];
    public $RTD_HANDOVER_SELECT = [0x48, 0x73];

    public $TLV_NDEF = 0x03;
    public $TLV_TERMINATOR = 0xFE;
}