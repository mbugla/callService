<?php
declare(strict_types=1);

namespace CS\ServiceApp\Sms\Application\Service;

use CS\ServiceApp\Response\Domain\SipGateSms;
use CS\ServiceApp\SMS\Domain\SmsCenter;
use CS\ServiceApp\SMS\Domain\SmsRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class SipGateSmsCenter implements SmsCenter, LoggerAwareInterface
{
    /** @var  LoggerInterface */
    private $logger;

    /** @var SipGateSms */
    private $smsTemplate;

    /** @var SmsRepository */
    private $smsRepository;

    /**
     * SipGateSmsCenter constructor.
     *
     * @param SipGateSms    $sms
     * @param SmsRepository $smsRepository
     */
    public function __construct(SipGateSms $sms, SmsRepository $smsRepository)
    {
        $this->smsTemplate = $sms;
        $this->smsRepository = $smsRepository;
    }

    /**
     * @param $callId
     *
     * @return string
     */
    public function sendForCall($callId)
    {
        $smsMessage = $this->smsRepository->findByCallId($callId);

        $this->smsTemplate->setRecipient($smsMessage->to());
        $this->smsTemplate->setContent($smsMessage->content());

        $response = $this->smsTemplate->getXmlResponse();

        if ($this->logger) {
            $this->logger->info('Message sent to: '.$smsMessage->to().' content: '.$smsMessage->content());
        }

        return $response;
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
