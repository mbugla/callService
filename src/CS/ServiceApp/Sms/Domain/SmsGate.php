<?php
declare(strict_types=1);

namespace CS\ServiceApp\Sms\Domain;

interface SmsGate
{
    public function sendForCall(string $callId);
}
