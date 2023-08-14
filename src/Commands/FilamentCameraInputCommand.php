<?php

namespace Machacekmartin\FilamentCameraInput\Commands;

use Illuminate\Console\Command;

class FilamentCameraInputCommand extends Command
{
    public $signature = 'filament-camera-input';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
