<?php
declare(strict_types=1);

namespace CS\ServiceApp\Sms\Domain;

interface SmsRepository
{
    public function store(Sms $sms);

    /**
     * @param string $callId
     *
     * @return Sms | null
     */
    public function findByCallId(string $callId);
}
