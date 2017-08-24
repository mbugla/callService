<?php

namespace Tests\CS\ServiceApp\CallCenter\Domain;

use CS\ServiceApp\Call\Application\Api\Handler\CallCommandHandler;
use CS\ServiceApp\Call\Application\Api\Handler\DtmfCommandDispatcher;
use CS\ServiceApp\Call\Application\Api\Handler\FormDtmfCommandHandler;
use CS\ServiceApp\Call\Application\Api\Handler\PremiumContentDtmfCommandHandler;
use CS\ServiceApp\Call\Domain\Call;
use CS\ServiceApp\Call\Domain\Dtmf;
use CS\ServiceApp\CallCenter\Application\CallCenter;
use CS\ServiceApp\Response\Application\ResponseFactory;
use CS\ServiceApp\Response\Domain\Gather;
use CS\ServiceApp\Response\Domain\Reject;
use CS\ServiceApp\Response\Domain\SipGateSms;
use PHPUnit\Framework\TestCase;
use Tests\CS\ServiceApp\Implementation\Logger\ConsoleLogger;
use Tests\CS\ServiceApp\Implementation\Repository\InMemoryCallRepository;
use Tests\CS\ServiceApp\Implementation\Repository\InMemoryClientRepository;
use Tests\CS\ServiceApp\Implementation\Repository\InMemoryFormRepository;
use Tests\CS\ServiceApp\Implementation\Repository\InMemorySmsRepository;

class CallCenterTest extends TestCase
{
    /**
     * @test
     */
    public function isAbleToHandleIncomingCall()
    {
        $clientRepository = new InMemoryClientRepository();
        $callRepository = new InMemoryCallRepository();
        $formRepository = new InMemoryFormRepository();
        $smsRespository = new InMemorySmsRepository();
        $logger = new ConsoleLogger();
        $smsCenter = new \Tests\CS\ServiceApp\Implementation\Sms\FakeSmsCenter();
        $smsCenter->setLogger($logger);

        $premiumContentDtmfHandler = new PremiumContentDtmfCommandHandler(
            'http://premium.dev',
            $callRepository,
            $smsRespository
        );
        $formDtmfHandler = new FormDtmfCommandHandler($callRepository, $formRepository, $smsRespository);
        $dtmfDispatcher = new DtmfCommandDispatcher($premiumContentDtmfHandler, $formDtmfHandler);
        $callCommandHandler = new CallCommandHandler($callRepository, $clientRepository);
        $responseFactory = new ResponseFactory(new Gather('http://app.dev', 'http://sound.vaw', 10000), new Reject());

        $callCenter = new CallCenter('lufthansa', $callCommandHandler, $dtmfDispatcher, $responseFactory, $smsCenter);

        $xmlResponse = $callCenter->handleIncomingEvent(
            ['event' => 'newCall', 'from' => '123123123', 'to' => '234234234', 'direction' => 'in', 'callId' => "1"]
        );

        $this->assertEquals('123123123', $callRepository->load("1")->getClient()->getPhoneNumber());
        $this->assertContains('<Gather onData="http://app.dev" maxDigits="1" timeout="10000">', $xmlResponse);
        $this->assertContains('<Play><Url>http://sound.vaw</Url></Play>', $xmlResponse);
    }

    /**
     * @test
     */
    public function isAbleToHandleDtmfSignal()
    {
        $clientRepository = new InMemoryClientRepository();
        $callRepository = new InMemoryCallRepository();
        $formRepository = new InMemoryFormRepository();
        $smsCenter = new SipGateSmsCenter(new SipGateSms('JohnDoe'));
        $logger = new ConsoleLogger();
        $smsCenter->setLogger($logger);

        $callCenter = new CallCenter(
            'lufthansa',
            $callRepository,
            $clientRepository,
            $formRepository,
            new Gather('http://app.dev', 'http://sound.vaw', 10000),
            $smsCenter
        );

        $call = new Call('newCall', '123123123', '234234234', 'in', "1", new \DateTime());
        $callCenter->handleIncomingCall($call);

        $dtmf = new Dtmf('dtmf', 1, '1');

        $smsResponse = $callCenter->handleDTMF($dtmf);

        $this->assertRegExp('#<string>(.*?): https?://(.*)/form/(\d+)</string>#', $smsResponse);
        $this->assertContains('<methodName>samurai.SessionInitiate</methodName>', $smsResponse);
    }
}
