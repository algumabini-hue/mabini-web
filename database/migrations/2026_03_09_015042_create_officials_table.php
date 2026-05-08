<?php

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
        Schema::create('officials', function (Blueprint $table) {
            $table->id();
            $table->string('position_key')->unique(); // e.g., 'mayor', 'councilor_1' (Useful for updating later)
            $table->string('name')->nullable();
            $table->string('position')->nullable(); // e.g., 'Municipal Mayor'
            $table->string('department')->nullable();
            $table->date('dob')->nullable();
            $table->string('pob')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('citizenship')->nullable();
            $table->text('description')->nullable();
            $table->string('photo_path')->nullable(); // Stores the image path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officials');
    }
};
