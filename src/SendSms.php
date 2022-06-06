<?php

namespace Parhaaam\SendSms;

use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Parhaaam\SendSms\Drivers\Kavenegar\KavenegarSmsProvider;
use Parhaaam\SendSms\Drivers\SmsIr\SmsIr;

class SendSms
{

    /**
     * Sms Provider service
     *
     * @var SmsProviderService
     */
    private $smsProviderService;

    /**
     * Sms drivers configs
     *
     * @var string
     */
    protected $configs;

    function __construct()
    {
        $this->configs = static::loadConfig();
        $this->via('default');
    }
    /**
     * Sets sms driver
     *
     * @return void
     */
    public function via($driver = 'default')
    {
        if ($driver == 'default') {
            $driver = $this->configs['default'];
        }

        $this->validateConfigs($driver);

        $config = $this->configs['drivers'][$driver];
        switch ($driver) {
            case 'kavenegar':
                $this->smsProviderService = new KavenegarSmsProvider($config['key']);

                break;
            case 'smsir':
                $this->smsProviderService = new SmsIr($config['key'],$config['secret']);

                break;

            default:
                $this->smsProviderService = new KavenegarSmsProvider($config['key']);

                break;
        }
        return $this;
    }

    /**
     * Sends normal sms
     *
     * @return void
     */
    public function sendSms($message, $sender, $receptor): mixed
    {
        $smsProvider = $this->smsProviderService;
        return $smsProvider->sendSms($message, $sender, $receptor);
    }

    /**
     * Sends lookup sms
     *
     * @return void
     */
    public function sendLookup($receptor, $template, ...$tokens): mixed
    {
        $smsProvider = $this->smsProviderService;
        return $smsProvider->sendLookup($receptor, $template, ...$tokens);
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
        if (!isset($this->configs['drivers'][$driver])) {
            throw new InvalidArgumentException("$driver is not defined in sendSms configs");
        }
    }
}
