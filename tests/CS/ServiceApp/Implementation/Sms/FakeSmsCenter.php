<?php
/**
 * Created by PhpStorm.
 * User: mbugla
 * Date: 24.08.2017
 * Time: 15:20
 */

namespace Tests\CS\ServiceApp\Implementation\Sms;

use CS\ServiceApp\Sms\Domain\SmsCenter;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class FakeSmsCenter implements SmsCenter, LoggerAwareInterface
{
    /** @var  LoggerInterface */
    private $logger;

    public function sendForCall(string $callId)
    {
        $this->logger->info('SMS messsage sent');

        return 100;
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
