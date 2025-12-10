<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Spesies Tanaman
        Schema::create('plant_species', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tomat Cherry
            $table->string('scientific_name')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            
            // Rekomendasi (Preventive)
            $table->text('soil_recommendation')->nullable();
            $table->string('planting_distance')->nullable();
            $table->string('sunlight_needs')->nullable();
            $table->integer('optimal_temp_min')->nullable();
            $table->integer('optimal_temp_max')->nullable();
            $table->integer('harvest_duration_days')->nullable(); // Estimasi hari
            
            $table->timestamps();
        });

        // 2. Tabel Master Penyakit (Issues)
        Schema::create('plant_issues', function (Blueprint $table) {
            $table->id();
            // Jika species_id NULL = Penyakit Umum, Jika Ada = Penyakit Spesifik Tanaman Tsb
            // onDelete('set null') artinya jika spesies dihapus, data penyakit tetap ada tapi id spesies jadi null
            $table->foreignId('species_id')->nullable()->constrained('plant_species')->nullOnDelete();
            
            $table->string('name'); // Layu Fusarium
            $table->string('scientific_name')->nullable();
            $table->text('symptoms')->nullable(); // Gejala visual
            $table->text('cause')->nullable();
            
            // Solusi (Curative)
            $table->text('solution')->nullable();
            $table->text('prevention')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plant_issues');
        Schema::dropIfExists('plant_species');
    }
};