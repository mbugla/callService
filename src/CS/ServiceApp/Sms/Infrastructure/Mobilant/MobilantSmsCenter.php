<?php
declare(strict_types=1);

namespace CS\ServiceApp\Sms\Infrastructure\Mobilant;

use CS\ServiceApp\Sms\Domain\SmsCenter;
use CS\ServiceApp\Sms\Domain\SmsRepository;
use DOMDocument;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class MobilantSmsCenter implements SmsCenter, LoggerAwareInterface
{
    /** @var  LoggerInterface */
    private $logger;

    /** @var SmsRepository */
    private $smsRepository;

    /** @var string */
    private $key;

    /** @var string */
    private $smsGateEndpoint;

    /**
     * MobilantSmsCenter constructor.
     *
     * @param string        $smsGateEndpoint
     * @param string        $key
     * @param SmsRepository $smsRepository
     */
    public function __construct(string $smsGateEndpoint, string $key, SmsRepository $smsRepository)
    {
        $this->key = $key;
        $this->smsRepository = $smsRepository;
        $this->smsGateEndpoint = $smsGateEndpoint;
    }

    /**
     * @param $callId
     *
     * @return string
     */
    public function sendForCall($callId)
    {
        $smsMessage = $this->smsRepository->findByCallId($callId);
        $this->logger->debug($callId);

        $url = $this->smsGateEndpoint; // URL des Gateways

        $param["key"] = $this->key; // Gateway Key
        $param["to"] = $smsMessage->to(); // Empfänger der SMS
        $param["message"] = $smsMessage->content(); // Inhalt der Nachricht
        $param["route"] = "gold";// Nutzung der Goldroute
        $param["from"] = "PREMIUM";// Absender der SMS

        $request = http_build_query($param);
        $this->logger->debug($request);

        // SMS kann jetzt versendet werden

        $ch = curl_init(); //initialize curl handle
        curl_setopt($ch, CURLOPT_URL, $url); //set the url
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return as a variable
        curl_setopt($ch, CURLOPT_POST, 1); //set POST method
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request); //set the POST variables
        $response = curl_exec($ch); //run the whole process and return the response
        curl_close($ch); //close the curl handle

        $responseCode = intval($response);

        if ($this->logger) {
            $this->logger->info(
                'Message sent to: '.$smsMessage->to().' content: '.$smsMessage->content(
                ).' with response code:'.$responseCode
            );
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $value = (string)$responseCode;
        $response = $dom->createElement('ResponseCode', $value);
        $dom->appendChild($response);

        return $dom->saveXML();
    }

    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
