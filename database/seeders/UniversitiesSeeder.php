<?php

declare(strict_types=1);

namespace Cortex\Universities\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Cortex\Universities\Models\University;

class UniversitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // truncate existing table data to avoid duplicates
        $this->command->info('Starting truncating existing table...');
        DB::table('universities')->truncate();

        // Path to the universities resources
        $universitiesPath = $this->getUniversitiesPath();

        if (!is_dir($universitiesPath)) {
            $this->command->error("Universities resources directory not found: {$universitiesPath}");
            return;
        }

        $this->command->info('Starting to import universities...');

        // Get all country directories
        $countryDirs = glob($universitiesPath . '/*', GLOB_ONLYDIR);

        $totalUniversities = 0;
        $processedCountries = 0;

        foreach ($countryDirs as $countryDir) {

            $batch = [];

            $countryCode = basename($countryDir);
            $jsonFiles = glob($countryDir . '/*.json');

            $countryCount = 0;

            foreach ($jsonFiles as $jsonFile) {
                try {
                    $data = json_decode(file_get_contents($jsonFile), true);

                    if (!$data) {
                        $this->command->warn("Invalid JSON file: {$jsonFile}");
                        continue;
                    }

                    // Transform the data to match our database structure
                    $universityData = $this->transformUniversityData($data);

                    $batch[] = $universityData;
                    $countryCount++;
                    $totalUniversities++;

                } catch (\Exception $e) {
                    $this->command->error("Error processing file {$jsonFile}: " . $e->getMessage());
                }
            }


            // Insert all records in one batch
            if (!empty($batch)) {
                University::insert($batch);
            }

            $processedCountries++;
            $this->command->line("Processed {$countryCount} universities from {$countryCode}");
        }

        $this->command->info("Successfully imported {$totalUniversities} universities from {$processedCountries} countries.");
    }

    /**
     * Transform university data from rinvex format to our database format.
     */
    protected function transformUniversityData(array $data): array
    {
        return [
            'name' => $data['name'] ?? null,
            'alt_name' => $data['alt_name'] ?? null,
            'country' => $data['country'] ?? null,
            'state' => $data['state'] ?? null,
            'street' => $data['address']['street'] ?? null,
            'city' => $data['address']['city'] ?? null,
            'province' => $data['address']['province'] ?? null,
            'postal_code' => $data['address']['postal_code'] ?? null,
            'telephone' => $data['contact']['telephone'] ?? null,
            'website' => $data['contact']['website'] ?? null,
            'email' => $data['contact']['email'] ?? null,
            'fax' => $data['contact']['fax'] ?? null,
            'funding' => $data['funding'] ?? null,
            'languages' => $data['languages'] ?? null,
            'academic_year' => $data['academic_year'] ?? null,
            'accrediting_agency' => $data['accrediting_agency'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Get the absolute path to universities resources.
     */
    protected function getUniversitiesPath(): string
    {
        // Try to find the rinvex/universities package using absolute paths
        $possiblePaths = [
            // base_path('../packages/universities/resources'), // Relative to cortex
            base_path('vendor/rinvex/universities/resources'), // In vendor
            dirname(__DIR__, 3) . '/universities/resources', // Relative to this package
        ];

        foreach ($possiblePaths as $path) {
            if (is_dir($path)) {
                return realpath($path);
            }
        }

        // Fallback to the known location in the current structure
        $fallbackPath = dirname(__DIR__, 3) . '/universities/resources';
        return is_dir($fallbackPath) ? realpath($fallbackPath) : $fallbackPath;
    }
}
