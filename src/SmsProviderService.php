<?php

namespace Parhaaam\SendSms;

interface SmsProviderService
{
    public function sendSms($message, $sender, $receptor);

    public function sendLookup($receptor, $template, array $tokens);
}
