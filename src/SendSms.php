<?php

namespace Parhaaam\SendSms;

abstract class SendSms
{
    abstract public function getSmsProviderConnection(): SmsProviderConnetcion;

    public function sendSms($message, $sender, $receptor): void
    {
        $smsProvider = $this->getSmsProviderConnection();
        $smsProvider->sendSms($message, $sender, $receptor);
    }

    public function sendLookup($receptor, $template, ...$tokens): void
    {
        $smsProvider = $this->getSmsProviderConnection();
        $smsProvider->sendLookup($receptor, $template, ...$tokens);
    }
}
