<?php

namespace CS\ServiceApp\Response\Domain;

use DOMDocument;

class SipGateSms implements SipGateResponse
{
    /** @var  string */
    private $content;

    /** @var string */
    private $sender;

    /** @var string */
    private $recipient;

    /**
     * SipGateSms constructor.
     *
     * @param string $sender
     */
    public function __construct(string $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @param string $recipient
     */
    public function setRecipient(string $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getXmlResponse()
    {
        if (!$this->content || !$this->recipient) {
            throw new \LogicException('Content and recipient are mandatory to send SMS');
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $methodCall = $dom->createElement('methodCall');
        $methodName = $dom->createElement('methodName', 'samurai.SessionInitiate');
        $params = $dom->createElement('params');
        $param = $dom->createElement('param');
        $value = $dom->createElement('value');
        $struct = $dom->createElement('struct');

        $localUriMember = $dom->createElement('member');
        $localUriName = $dom->createElement('name', 'LocalUri');
        $localUriMemberValue = $dom->createElement('value');
        $localUriString = $dom->createElement('string', $this->sender);
        $localUriMemberValue->appendChild($localUriString);
        $localUriMember->appendChild($localUriName);
        $localUriMember->appendChild($localUriMemberValue);

        $remoteUriMember = $dom->createElement('member');
        $remoteUriName = $dom->createElement('name', 'RemoteUri');
        $remoteUriMemberValue = $dom->createElement('value');
        $remoteUriString = $dom->createElement('string', $this->recipient);
        $remoteUriMemberValue->appendChild($remoteUriString);
        $remoteUriMember->appendChild($remoteUriName);
        $remoteUriMember->appendChild($remoteUriMemberValue);

        $tosMember = $dom->createElement('member');
        $tosMemberName = $dom->createElement('name', 'TOS');
        $tosMemberValue = $dom->createElement('value');
        $tosMemberString = $dom->createElement('string', 'tos');
        $tosMemberValue->appendChild($tosMemberString);
        $tosMember->appendChild($tosMemberName);
        $tosMember->appendChild($tosMemberValue);

        $contentMember = $dom->createElement('member');
        $contentMemberName = $dom->createElement('name', 'Content');
        $contentMemberValue = $dom->createElement('value');
        $contentMemberString = $dom->createElement('string', $this->content);
        $contentMemberValue->appendChild($contentMemberString);
        $contentMember->appendChild($contentMemberName);
        $contentMember->appendChild($contentMemberValue);

        $struct->appendChild($localUriMember);
        $struct->appendChild($remoteUriMember);
        $struct->appendChild($tosMember);
        $struct->appendChild($contentMember);

        $value->appendChild($struct);

        $param->appendChild($value);
        $params->appendChild($param);
        $methodCall->appendChild($methodName);
        $methodCall->appendChild($params);
        $dom->appendChild($methodCall);

        return $dom->saveXML();
    }
}
