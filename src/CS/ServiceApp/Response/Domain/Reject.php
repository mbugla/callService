<?php
declare(strict_types=1);

namespace CS\ServiceApp\Response\Domain;

use DOMDocument;

class Reject implements SipGateResponse
{
    /**
     * @return string
     */
    public function getXmlResponse(): string
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $response = $dom->createElement('Response');
        $reject = $dom->createElement('Reject');
        $reject->setAttribute('reason', 'reject');
        $response->appendChild($reject);
        $dom->appendChild($response);

        return $dom->saveXML();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getXmlResponse();
    }
}
