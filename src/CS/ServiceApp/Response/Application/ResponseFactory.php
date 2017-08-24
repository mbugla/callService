<?php
declare(strict_types=1);

namespace CS\ServiceApp\Response\Application;

use CS\ServiceApp\Response\Domain\Gather;
use CS\ServiceApp\Response\Domain\Reject;
use CS\ServiceApp\Response\Domain\SipGateResponse;

class ResponseFactory
{
    const TYPE_GATHER = 'gather';
    const TYPE_REJECT = 'reject';

    /** @var Gather */
    private $gather;

    /** @var Reject */
    private $reject;

    /**
     * ResponseFactory constructor.
     *
     * @param Gather $gather
     * @param Reject $reject
     */
    public function __construct(Gather $gather, Reject $reject)
    {
        $this->gather = $gather;
        $this->reject = $reject;
    }

    /**
     * @param string $type
     *
     * @return SipGateResponse
     */
    public function getByType(string $type) : SipGateResponse
    {
        switch ($type) {
            case self::TYPE_GATHER:
                return $this->gather;
            case self::TYPE_REJECT:
                return $this->reject;
        }

        return $this->gather;
    }
}
