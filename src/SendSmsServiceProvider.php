<?php

namespace Parhaaam\SendSms;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Parhaaam\SendSms\Commands\SendSmsCommand;

class SendSmsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('sendsms')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_sendsms_table')
            ->hasCommand(SendSmsCommand::class);
    }
}
