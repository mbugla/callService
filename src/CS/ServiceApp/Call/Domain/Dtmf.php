<?php
declare(strict_types=1);

namespace CS\ServiceApp\Call\Domain;

class Dtmf
{
    private $event;

    private $callId;

    private $dtmf;

    public function __construct(string $event = 'dtmf', int $dtmf, string $callId)
    {
        $this->event = $event;
        $this->dtmf = $dtmf;
        $this->callId = $callId;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @return string
     */
    public function getCallId(): string
    {
        return $this->callId;
    }

    /**
     * @return int
     */
    public function getDtmf(): int
    {
        return $this->dtmf;
    }

    /**
     * @param array $dtmfData
     *
     * @return static
     */
    public static function createFromArray(array $dtmfData)
    {
        return new static($dtmfData['event'],$dtmfData['dtmf'],$dtmfData['callId']);
    }
}
