<?php
declare(strict_types=1);

namespace CS\ServiceApp\CallCenter\Application\Api\Command;

use CS\ServiceApp\Call\Domain\Call;

class CallCommand
{
    /** @var Call */
    private $call;

    /**
     * NewCallCommand constructor.
     *
     * @param $event
     * @param $from
     * @param $to
     * @param $direction
     * @param $callId
     */
    public function __construct($event, $from, $to, $direction, $callId)
    {
        $this->call = Call::createFromArray(
            [
                'event' => $event,
                'from' => $from,
                'to' => $to,
                'direction' => $direction,
                'callId' => $callId,
                'createdAt' => new \DateTime(),
            ]
        );
    }

    /**
     * @return Call
     */
    public function getCall(): Call
    {
        return $this->call;
    }
}
