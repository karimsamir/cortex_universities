<?php

declare(strict_types=1);

namespace Cortex\Universities\Console\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Console\Command;

#[AsCommand(name: 'cortex:migrate:universities')]
class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:migrate:universities {--f|force : Force the operation to run when in production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Cortex Universities Tables.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $path = config('cortex.universities.autoload_migrations') ?
            realpath(__DIR__.'/../../../database/migrations') :
            $this->laravel->databasePath('migrations/cortex/universities');

        if (file_exists($path)) {
            $this->call('migrate', [
                '--step' => true,
                '--path' => $path,
                '--realpath' => true,
                '--force' => $this->option('force'),
            ]);
        } else {
            $this->warn('No migrations found! Consider publish them first: <fg=green>php artisan cortex:publish:universities</>');
        }

        $this->line('');
    }
}
