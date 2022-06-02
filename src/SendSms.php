<?php

namespace Parhaaam\SendSms;

use InvalidArgumentException;
use Parhaaam\SendSms\Drivers\Kavenegar\KavenegarSmsProvider;

class SendSms
{
    private $smsProviderService;

    
    public function __construct()
    {
        $this->via($driver = 'default');
    }

    public function via($driver = 'default')
    {

        $configs =  $this->loadConfig();

        if ($driver == 'default') {
            $driver = $configs['default'];
        }

        $this->validateConfigs($driver);

        $cofings = $configs['drivers'][$driver];
        switch ($driver) {
            case 'kavenegar':
                $this->smsProviderService = new KavenegarSmsProvider($cofings['key']);
                break;

            default:
                $this->smsProviderService = new KavenegarSmsProvider($cofings['key']);
                break;
        }
    }

    /**
     * Sends normal sms 
     *
     * @return void
     */
    public function sendSms($message, $sender, $receptor): void
    {
        $smsProvider = $this->smsProviderService;
        $smsProvider->sendSms($message, $sender, $receptor);
    }

    /**
     * Sends lookup sms 
     *
     * @return void
     */
    public function sendLookup($receptor, $template, ...$tokens): void
    {
        $smsProvider = $this->smsProviderService;
        $smsProvider->sendLookup($receptor, $template, ...$tokens);
    }

    /**
     * Retrieve  config data.
     *
     * @return array
     */
    protected function loadConfig(): array
    {
        $configs = config('sendsms');
        if (is_null($configs)) {
            $configs = static::loadDefaultConfig();
        }
        return $configs;
    }
    /**
     * Retrieve default config.
     *
     * @return array
     */
    protected function loadDefaultConfig(): array
    {
        return require(static::getDefaultConfigPath());
    }

    /**
     * Retrieve Default config's path.
     *
     * @return string
     */
    protected static function getDefaultConfigPath(): string
    {
        return dirname(__DIR__) . '/config/sendsms.php';
    }

    /**
     * Validate Configs.
     *
     * @return void
     */

    protected function validateConfigs($driver): void
    {
        if (!isset(config('sendsms')['drivers'][$driver])) {
            throw new InvalidArgumentException("$driver is not defined in sendSms configs");
        }
    }
}
