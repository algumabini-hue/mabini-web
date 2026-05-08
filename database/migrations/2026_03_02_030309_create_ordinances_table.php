<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ordinances', function (Blueprint $table) {
            $table->id();
            // Core Info
            $table->date('date_implemented')->nullable();
            $table->longText('subject')->nullable();
            $table->longText('legal_basis')->nullable();
            $table->longText('findings')->nullable();
            $table->longText('description')->nullable();

            // Authorship
            $table->string('drafted_by')->nullable();
            $table->json('signed_by')->nullable(); // Stores the 5 names as a JSON array

            // Sections
            $table->json('sections')->nullable(); // Stores the 10 sections as a JSON array
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordinances');
    }
};
