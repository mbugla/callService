<?php

namespace Tests\CS\ServiceApp\Implementation\Repository;

use CS\ServiceApp\Sms\Domain\Sms;
use CS\ServiceApp\Sms\Domain\SmsRepository;

class InMemorySmsRepository implements SmsRepository
{
    /** @var Sms[] */
    private $messages = [];

    public function store(Sms $sms)
    {
        $this->messages[] = $sms;
    }

    /**
     * @param string $callId
     *
     * @return Sms | null
     */
    public function findByCallId(string $callId)
    {
        foreach ($this->messages as $sms) {
            if($sms->getCall()->getCallId() === $callId) {
                return $sms;
            }
        }

        return null;
    }
}
