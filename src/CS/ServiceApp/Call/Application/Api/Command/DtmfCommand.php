<?php
declare(strict_types=1);

namespace CS\ServiceApp\Call\Application\Api\Command;

use CS\ServiceApp\Call\Domain\Dtmf;

class DtmfCommand
{
    /** @var Dtmf */
    private $dtmf;

    /**
     * DtmfCommand constructor.
     *
     * @param string $event
     * @param int    $dtmf
     * @param string $callId
     */
    public function __construct(string $event, int $dtmf, string $callId)
    {
        $this->dtmf = Dtmf::createFromArray(['event' => $event, 'dtmf' => $dtmf, 'callId' => $callId]);
    }

    /**
     * @return Dtmf
     */
    public function getDtmf(): Dtmf
    {
        return $this->dtmf;
    }
}
