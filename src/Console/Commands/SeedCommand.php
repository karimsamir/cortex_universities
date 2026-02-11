<?php

declare(strict_types=1);

namespace Cortex\Universities\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Cortex\Universities\Database\Seeders\CortexUniversitiesSeeder;

#[AsCommand(name: 'cortex:seed:universities')]
class SeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cortex:seed:universities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Cortex Universities Data.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->alert($this->description);

        $this->call('db:seed', ['--class' => CortexUniversitiesSeeder::class]);

        $this->line('');
    }
}
