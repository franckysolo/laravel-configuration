<?php

namespace Indy\LaravelConfiguration\Console;

use Indy\LaravelConfiguration\ConfigurationServiceProvider;
use Illuminate\Console\Command;

class InstallConfigurationCommand extends command
{
    protected $signature = 'configuration:install';

    protected $description = 'Install the Laravel Configuration Package';

    public function handle()
    {
        $this->info('Installing Laravel Configuration Package...');

        $this->comment('Publishing Laravel Configuration Package settings...');
        $this->callSilent('vendor:publish', ['--tag' => 'configurations-settings']);

        $this->comment('Publishing Laravel Configuration Package migrations...');
        $this->callSilent('vendor:publish', ['--tag' => 'configurations-migrations']);

        $this->comment('Publishing Laravel Configuration Package translations...');
        $this->callSilent('vendor:publish', ['--tag' => 'configurations-translations']);

        $this->comment('Publishing Laravel Configuration Package views...');
        $this->callSilent('vendor:publish', ['--tag' => 'configurations-views']);

        $this->info('Installed Laravel Configuration Package');
    }
}
