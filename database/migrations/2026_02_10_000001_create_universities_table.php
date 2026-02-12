<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('cortex.universities.tables.universities'), function (Blueprint $table) {
            $table->id();
            $table->string('name', 256);
            $table->string('alt_name', 256)->nullable();
            $table->string('slug', 256)->unique();
            $table->string('country', 100);
            $table->string('country_code', 10);
            $table->string('state', 100)->nullable();
            $table->string('street', 150)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('postal_code', 100)->nullable();
            $table->string('telephone', 200)->nullable();
            $table->string('fax', 200)->nullable();
            $table->string('website', 256)->nullable();
            $table->string('email', 256)->nullable();
            $table->string('funding', 20)->nullable();
            $table->json('languages')->nullable();
            $table->text('academic_year')->nullable();
            $table->text('accrediting_agency')->nullable();
            $table->auditableAndTimestamps();


            // Indexes for better performance
            $table->index('country');
            $table->index('state');
            $table->index('funding');
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('cortex.universities.tables.universities'));
    }
};
