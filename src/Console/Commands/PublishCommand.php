<?php

declare(strict_types=1);

namespace Cortex\Universities\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Console\Command;

#[AsCommand(name: 'cortex:publish:universities')]
class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:publish:universities {--f|force : Overwrite any existing files.} {--r|resource=* : Specify which resources to publish.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Cortex Universities Resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        collect($this->option('resource') ?: ['config', 'lang', 'views', 'migrations'])->each(function ($resource) {
            $this->call('vendor:publish', ['--tag' => "cortex/universities::{$resource}", '--force' => $this->option('force')]);
        });

        $this->line('');
    }
}
