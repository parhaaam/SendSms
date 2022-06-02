<?php

namespace Parhaaam\SendSms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Parhaaam\SendSms\SendSms
 */
class SendSms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sendsms';
    }
}
