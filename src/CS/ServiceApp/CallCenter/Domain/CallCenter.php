<?php
declare(strict_types=1);

namespace CS\ServiceApp\CallCenter\Domain;

use CS\ServiceApp\CallCenter\Application\Api\Handler\CallCommandHandler;
use CS\ServiceApp\CallCenter\Application\Api\Command\CallCommand;
use CS\ServiceApp\CallCenter\Application\Api\Command\DtmfCommand;
use CS\ServiceApp\CallCenter\Application\Api\Handler\DtmfCommandHandler;
use CS\ServiceApp\Response\Domain\SipGateResponse;
use CS\ServiceApp\SMS\Domain\SmsCenter;

class CallCenter
{
    const NEW_CALL_EVENT = 'newCall';
    const DTMF_EVENT = 'dtmf';
    /** @var string */
    private $name;

    /** @var SmsCenter */
    private $smsCenter;

    /** @var SipGateResponse */
    private $sipGateResponse;

    /** @var CallCommandHandler */
    private $callCommandHandler;
    /**
     * @var DtmfCommandHandler
     */
    private $dtmfCommandHandler;

    /**
     * CallCenter constructor.
     *
     * @param string             $name
     * @param CallCommandHandler $callCommandHandler
     * @param DtmfCommandHandler $dtmfCommandHandler
     * @param SipGateResponse    $sipGateResponse
     * @param SmsCenter          $smsCenter
     */
    public function __construct(
        string $name,
        CallCommandHandler $callCommandHandler,
        DtmfCommandHandler $dtmfCommandHandler,
        SipGateResponse $sipGateResponse,
        SmsCenter $smsCenter
    ) {
        $this->name = $name;
        $this->smsCenter = $smsCenter;
        $this->sipGateResponse = $sipGateResponse;
        $this->callCommandHandler = $callCommandHandler;
        $this->dtmfCommandHandler = $dtmfCommandHandler;
    }

    public function handleIncomingEvent(array $eventData)
    {
        switch ($eventData['event']) {
            case self::NEW_CALL_EVENT:
                return $this->handleCall($eventData);
            case self::DTMF_EVENT:
                return $this->handleDtmf($eventData);
        }
    }

    /**
     * @param array $callEvent
     *
     * @return string
     */
    public function handleCall(array $callEvent): string
    {
        $command = new CallCommand(
            $callEvent['event'],
            $callEvent['from'],
            $callEvent['to'],
            $callEvent['direction'],
            $callEvent['callId']
        );

        $this->callCommandHandler->handle($command);

        return $this->sipGateResponse->getXmlResponse();
    }

    /**
     * @param array $dtmfEvent
     *
     * @return string
     */
    public function handleDtmf(array $dtmfEvent): string
    {
        $command = new DtmfCommand($dtmfEvent['event'], (int)$dtmfEvent[self::DTMF_EVENT], $dtmfEvent['callId']);

        $this->dtmfCommandHandler->handleDTMF($command);

        return $this->smsCenter->sendForCall($dtmfEvent['callId']);
    }

}
