<?php
declare(strict_types=1);

namespace CS\ServiceApp\Call\Domain;

use CS\ServiceApp\Client\Domain\Client;

class Call
{
    const AVAILABLE_EVENTS = ['newCall'];

    private $event;

    private $from;

    private $to;

    private $direction;

    private $callId;

    private $client;

    private $createdAt;

    /**
     * Call constructor.
     *
     * @param string $event
     * @param string $from
     * @param string $to
     * @param string $direction
     * @param string $callId
     * @param \DateTime $createdAt
     */
    public function __construct(
        string $event,
        string $from,
        string $to,
        string $direction,
        string $callId,
        \DateTime $createdAt
    ) {
        if (!in_array($event, static::AVAILABLE_EVENTS)) {
            throw new \InvalidArgumentException(sprintf('event % not supported', $event));
        }

        $this->event = $event;
        $this->from = $from;
        $this->to = $to;
        $this->direction = $direction;
        $this->callId = $callId;
        $this->createdAt = $createdAt;
    }

    /**
     * @param Client $client
     */
    public function assignClient(Client $client)
    {
        $this->client = $client;
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
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @return string
     */
    public function getCallId(): string
    {
        return $this->callId;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public static function createFromArray(array $callData)
    {
        return new Call(
            $callData['event'],
            $callData['from'],
            $callData['to'],
            $callData['direction'],
            $callData['callId'],
            $callData['createdAt']
        );
    }
}
