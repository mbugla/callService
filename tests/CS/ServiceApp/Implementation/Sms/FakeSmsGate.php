<?php
declare(strict_types=1);

namespace Tests\CS\ServiceApp\Implementation\Sms;

use CS\ServiceApp\Sms\Domain\SmsGate;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class FakeSmsGate implements SmsGate, LoggerAwareInterface
{
    /** @var  LoggerInterface */
    private $logger;
    /** @var int */
    private $responseCode;

    /**
     * FakeSmsCenter constructor.
     *
     * @param $responseCode
     */
    public function __construct(int $responseCode = 100)
    {
        $this->responseCode = $responseCode;
    }

    public function sendForCall(string $callId)
    {
        $this->logger->info('SMS messsage sent');

        return $this->responseCode;
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
