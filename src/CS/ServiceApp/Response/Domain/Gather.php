<?php
declare(strict_types=1);

namespace CS\ServiceApp\Response\Domain;

use DOMDocument;

class Gather implements SipGateResponse
{
    /** @var string */
    private $gatherUrl;

    /** @var string */
    private $soundPath;

    /** @var string */
    private $timeout;

    /**
     * Gather constructor.
     *
     * @param $gatherUrl
     * @param $soundPath
     * @param $timeout
     */
    public function __construct($gatherUrl, $soundPath, $timeout)
    {
        $this->gatherUrl = $gatherUrl;
        $this->soundPath = $soundPath;
        $this->timeout = $timeout;
    }

    public function getXmlResponse()
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $response = $dom->createElement('Response');
        $dom->appendChild($response);
        $gather = $dom->createElement('Gather');
        $gather->setAttribute('onData', $this->gatherUrl);
        $gather->setAttribute('maxDigits', '1');
        $gather->setAttribute('timeout', (string)$this->timeout);
        $play = $dom->createElement('Play');
        $url = $dom->createElement('Url',$this->soundPath);
        $play->appendChild($url);
        $gather->appendChild($play);
        $response->appendChild($gather);
        $dom->appendChild($response);

        return $dom->saveXml();
    }
}
