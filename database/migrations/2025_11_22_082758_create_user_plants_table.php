<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tanaman Milik User
        Schema::create('user_plants', function (Blueprint $table) {
            $table->id();
            // Jika user dihapus, tanaman user ikut terhapus (cascade)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('species_id')->constrained('plant_species');
            
            $table->string('nickname')->nullable();
            $table->string('location_type')->nullable(); // indoor, outdoor, greenhouse
            $table->date('planting_date')->nullable();
            
            // Status Real-time
            $table->string('growth_stage')->default('seedling'); // seedling, vegetative, flowering, fruiting
            $table->string('status')->default('healthy'); // healthy, sick, dead
            
            $table->timestamps();
        });

        // 2. History Scan AI
        Schema::create('scan_histories', function (Blueprint $table) {
            $table->id();
            // Jika tanaman user dihapus, history scan ikut hilang
            $table->foreignId('user_plant_id')->constrained('user_plants')->cascadeOnDelete();
            
            // Hasil Diagnosa (Bisa null jika sehat atau tidak terdeteksi)
            $table->foreignId('detected_issue_id')->nullable()->constrained('plant_issues');
            
            $table->float('confidence_score')->nullable(); // 0-100%
            $table->string('image_path');
            $table->text('user_notes')->nullable();
            $table->text('ai_raw_response')->nullable(); // Simpan JSON raw untuk debug
            
            $table->timestamp('scanned_at')->useCurrent();
        });

        // 3. Log Perawatan (Care Logs)
        Schema::create('care_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_plant_id')->constrained('user_plants')->cascadeOnDelete();
            
            $table->string('action_type'); // watering, fertilizing, pruning
            $table->text('notes')->nullable();
            $table->timestamp('performed_at')->useCurrent();
        });

        // 4. Log Pertumbuhan (Monitoring Logs - Data Angka)
        Schema::create('monitoring_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_plant_id')->constrained('user_plants')->cascadeOnDelete();
            
            $table->float('height_cm')->nullable();
            $table->integer('leaf_count')->nullable();
            $table->string('condition')->nullable(); // excellent, good, bad
            $table->date('log_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_logs');
        Schema::dropIfExists('care_logs');
        Schema::dropIfExists('scan_histories');
        Schema::dropIfExists('user_plants');
    }
};