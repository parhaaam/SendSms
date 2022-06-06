<?php

namespace Parhaaam\SendSms\Drivers\Kavenegar;

use Kavenegar\KavenegarApi;
use Parhaaam\SendSms\SmsProviderService;

class KavenegarSmsProvider implements SmsProviderService
{
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function sendSms($message, $sender, $receptor)
    {
        try {
            $api = new KavenegarApi($this->apiKey);

            return $result = $api->Send($sender, $receptor, $message);
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
    }

    public function sendLookup($receptor, $template, array $tokens)
    {
        try {
            $api = new KavenegarApi($this->apiKey);
            $token = $tokens[0] ?? '';
            $token2 = $tokens[1] ?? '';
            $token3 = $tokens[2] ?? '';

            return $result = $api->VerifyLookup($receptor, $token, $token2, $token3, $template, $type = 'sms');
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
    }
}
