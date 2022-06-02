<?php

namespace Parhaaam\SendSms\Commands;

use Illuminate\Console\Command;

class SendSmsCommand extends Command
{
    public $signature = 'sendsms';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
