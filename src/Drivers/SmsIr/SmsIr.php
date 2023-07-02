<?php

namespace Parhaaam\SendSms\Drivers\SmsIr;

use Parhaaam\SendSms\SmsProviderService;
use Parhaaam\SendSms\Traits\HasConfigs;

class SmsIr implements SmsProviderService
{
    use HasConfigs;
    private $apiKey;
    private $secret;
    public const APIPATH = "https://RestfulSms.com/%s/%s";
    public const VERSION = "1.2";

    public function __construct()
    {
        $this->apiKey = static::getDriverConfigsByKey("smsir", "key");
        $this->secret = static::getDriverConfigsByKey("smsir", "secret");
    }

    protected function get_path($method, $base = 'api')
    {
        return sprintf(self::APIPATH, $base, $method);
    }

    protected function execute($url, $data = null, $headers = [])
    {
        $defaultHeaders = collect([
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'charset: utf-8',
        ]);
        $headers = collect($headers);
        $headers = $defaultHeaders->merge($headers)->toArray();
        $fields_string = "";
        if (! is_null($data)) {
            $fields_string = http_build_query($data);
        }

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);

        $response = curl_exec($handle);

        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $content_type = curl_getinfo($handle, CURLINFO_CONTENT_TYPE);
        $curl_errno = curl_errno($handle);
        $curl_error = curl_error($handle);
        curl_close($handle);

        if ($curl_errno) {
            return $curl_error . '**' . $curl_errno;
            //throw new HttpException($curl_error, $curl_errno);
        }
        $json_response = json_decode($response);

        if ($code != 200 && is_null($json_response)) {
            return "Request have errors " . $code;
            //throw new HttpException("Request have errors", $code);
        } else {
            if ($json_response->IsSuccessful == true) {
                if (isset($data['UserApiKey'])) {
                    return
                        [
                            'TokenKey' => $json_response->TokenKey,
                            'Response' => $json_response,
                        ];
                } else {
                    return $json_response;
                }
            }

            return $json_response;
        }
    }

    public function sendSms($messages, $receptor, $sender): mixed
    {
        $path = $this->get_path("MessageSend");
        $params = [
            'Messages' => (array)$messages,
            'MobileNumbers' => (array)$receptor,
            'LineNumber' => $sender,
        ];
        $headers[] = 'x-sms-ir-secure-token: ' . $this->getToken()['TokenKey'];

        return $this->execute($path, $params, $headers);
    }

    public function sendLookup($receptor, $template, array $tokens): mixed
    {
        $path = $this->get_path("UltraFastSend");
        $params = [
            'TemplateId' => $template,
            'Mobile' => $receptor,
        ];
        foreach ($tokens as $key => $value) {
            $params['ParameterArray'][] = ['Parameter' => $key, 'ParameterValue' => $value];
        }
        // return $params;
        $headers[] = 'x-sms-ir-secure-token: ' . $this->getToken()['TokenKey'];

        return $this->execute($path, $params, $headers);
    }

    public function getToken()
    {
        $path = $this->get_path("Token");
        $params = [
            'UserApiKey' => $this->apiKey,
            'SecretKey' => $this->secret,
            'System' => 'php_rest_v_1_2',
        ];

        return $this->execute($path, $params);
    }
}
