<?php

namespace Parhaaam\SendSms;

interface  SmsProviderService
{
    public function sendSms($message, $sender, $receptor): void;
    public function sendLookup($receptor, $template, ...$tokens): void;
}
