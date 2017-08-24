<?php

namespace Tests\CS\ServiceApp\Sms\Domain;

use CS\ServiceApp\Call\Domain\Call;
use CS\ServiceApp\Sms\Domain\Sms;
use PHPUnit\Framework\TestCase;

class SmsTest extends TestCase
{
    /**
     * @test
     */
    public function hasDefinedBasicData()
    {
        $sms = new Sms('666', 'sms content', \DateTime::createFromFormat('Y-m-d H:i:s', '2017-08-24 10:00:00'));

        $this->assertSame('666', $sms->to());
        $this->assertSame('sms content', $sms->content());
        $this->assertSame('2017-08-24 10:00:00', $sms->getCreatedAt()->format('Y-m-d H:i:s'));
    }

    /**
     * @test
     */
    public function whenSmsIsConnectedWithCallThereCanBeCallAssigned()
    {
        $sms = new Sms('+666', 'sms content', \DateTime::createFromFormat('Y-m-d H:i:s', '2017-08-24 10:00:00'));
        $call = new Call(
            'newCall',
            '777',
            '666',
            'in',
            '123',
            \DateTime::createFromFormat('Y-m-d H:i:s', '2017-08-24 10:00:00')
        );

        $sms->assignCall($call);

        $this->assertSame($call, $sms->getCall());
    }

    /**
     * @test
     */
    public function whenSmsIsSentCanBeMarkedAsSent()
    {
        $dateTime = \DateTime::createFromFormat('Y-m-d H:i:s', '2017-08-24 10:00:00');
        $sms = new Sms('+666', 'sms content', $dateTime);

        $this->assertFalse($sms->isSent());

        $sms->wasSentAt($dateTime);

        $this->assertTrue($sms->isSent());
    }
}
