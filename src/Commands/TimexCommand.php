<?php

namespace Buildix\Timex\Commands;

use Illuminate\Console\Command;

class TimexCommand extends Command
{
    public $signature = 'timex';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
