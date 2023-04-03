<?php

namespace Parhaaam\SendSms;

use Parhaaam\SendSms\Traits\HasConfigs;

class SendSms
{
    use HasConfigs;

    /**
     * Sms Provider service
     *
     * @var SmsProviderService
     */
    private $smsProviderService;


    /**
     * SendSms Instance
     *
     * @var SendSms
     */
    private static $instance;

    public function __construct()
    {
        $this->initialDefaultBehaviour();
    }

    /**
     * Get Instance of SendSms method statically
     * 
     */
    public static function getInstance(): SendSms
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * smsProviderService setter
     *
     */
    private function setSmsProviderService(SmsProviderService $smsProviderService): void
    {
        $this->smsProviderService = $smsProviderService;
    }

    /**
     * smsProviderService getter
     *
     * @return SmsProviderService
     */
    private function getSmsProviderService(): SmsProviderService
    {
        return $this->smsProviderService;
    }


    /**
     * Implementation of php callStatic magic
     * method to use this class statically
     */
    public static function __callStatic($name, $arguments)
    {
        return static::getInstance()->$name(...$arguments);
    }

    /**
     * Sets sms driver
     *
     * @return SendSms
     */
    public function via(string $driverKey): SendSms
    {
        $smsProviderService = $this->getSmsProviderServiceFromDriver($driverKey);
        $this->setSmsProviderService($smsProviderService);
        return $this;
    }

    /**
     * Sends normal sms
     *
     * @return mixed
     */
    public function sendSms($message, $sender, $receptor): mixed
    {
        return $this->getSmsProviderService()->sendSms($message, $sender, $receptor);
    }

    /**
     * Sends lookup sms
     *
     * @return mixed
     */
    public function sendLookup($receptor, $template, ...$tokens): mixed
    {
        return $this->getSmsProviderService()->sendLookup($receptor, $template, ...$tokens);
    }

    /**
     * Checks if driver has provider class defined in configs
     *
     * @return void
     */
    protected function checkSmsProviderServiceFromDriverExists(string $driverKey): void
    {
        if (!isset(self::getDriverFromConfigs($driverKey)['provider_class'])) {
            throw new \InvalidArgumentException("[$driverKey] does not has provider_class in sendSms configs at config/sendsms.php");
        }
    }

    /**
     * Return related SmsProviderClass to driver key
     *
     * @return SmsProviderService
     */
    protected function getSmsProviderServiceFromDriver(string $driverKey): SmsProviderService
    {
        $this->checkSmsProviderServiceFromDriverExists($driverKey);
        return self::getDriverFromConfigs($driverKey)['provider_class'];
    }

    /**
     * Initial default behaviour of the SendSms class
     *
     * @return void
     */
    protected function initialDefaultBehaviour(): void
    {
        $this->via('default');
    }
}
