<?php

declare(strict_types=1);

namespace Cortex\Universities\Database\Seeders;

use Illuminate\Database\Seeder;
use Cortex\Universities\Models\University;

class CortexUniversitiesSeeder extends Seeder
{
       /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abilities = [
            ['name' => 'list', 'title' => 'List universities', 'entity_type' => 'university'],
            ['name' => 'view', 'title' => 'View universities', 'entity_type' => 'university'],
            ['name' => 'import', 'title' => 'Import universities', 'entity_type' => 'university'],
            ['name' => 'export', 'title' => 'Export universities', 'entity_type' => 'university'],
            ['name' => 'create', 'title' => 'Create universities', 'entity_type' => 'university'],
            ['name' => 'update', 'title' => 'Update universities', 'entity_type' => 'university'],
            ['name' => 'delete', 'title' => 'Delete universities', 'entity_type' => 'university'],
            ['name' => 'audit', 'title' => 'Audit universities', 'entity_type' => 'university'],
        ];

        collect($abilities)->each(function (array $ability) {
            app('cortex.auth.ability')->firstOrCreate([
                'name' => $ability['name'],
                'entity_type' => $ability['entity_type'],
            ], $ability);
        });
    }
}
