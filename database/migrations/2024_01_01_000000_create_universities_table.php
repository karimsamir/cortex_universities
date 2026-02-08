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
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256);
            $table->string('alt_name', 256)->nullable();
            $table->string('country');
            $table->string('state')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('telephone')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->string('funding')->nullable();
            $table->json('languages')->nullable();
            $table->text('academic_year')->nullable();
            $table->text('accrediting_agency')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('universities');
    }
};
