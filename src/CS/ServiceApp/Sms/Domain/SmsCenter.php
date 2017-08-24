<?php
declare(strict_types=1);

namespace CS\ServiceApp\Sms\Domain;

interface SmsCenter
{
    public function sendForCall($callId);
}
