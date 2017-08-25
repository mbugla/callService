<?php
declare(strict_types=1);

namespace CS\ServiceApp\Sms\Infrastructure\Mobilant;

use CS\ServiceApp\Sms\Domain\Sms;
use CS\ServiceApp\Sms\Domain\SmsGate;
use CS\ServiceApp\Sms\Domain\SmsRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class MobilantSmsGate implements SmsGate, LoggerAwareInterface
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
    public function sendForCall(string $callId)
    {
        $smsMessage = $this->smsRepository->findByCallId($callId);
        $this->logger->debug($callId);

        $responseCode = $this->send($smsMessage);

        if($responseCode === 100) {
            $smsMessage->wasSentAt(new \DateTime());
            $this->smsRepository->store($smsMessage);

            if ($this->logger) {
                $this->logger->info(
                    'Message sent to: '.$smsMessage->to().' content: '.$smsMessage->content(
                    ).' with response code:'.$responseCode
                );
            }

            return;
        }



        return;
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

    /**
     * @param Sms $smsMessage
     *
     * @return int
     */
    private function send(Sms $smsMessage): int
    {
        $param["key"] = $this->key;
        $param["to"] = $smsMessage->to();
        $param["message"] = $smsMessage->content();
        $param["route"] = "gold";
        $param["from"] = "PREMIUM";

        $request = http_build_query($param);
        $this->logger->debug($request);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->smsGateEndpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        $response = curl_exec($ch);
        curl_close($ch);

        return (int)$response;
    }
}
