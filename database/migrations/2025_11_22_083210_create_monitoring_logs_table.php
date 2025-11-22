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
        Schema::create('monitoring_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_plant_id')->constrained('user_plants')->onDelete('cascade');
    
    $table->date('log_date')->default(now());
    $table->float('height_cm')->nullable();
    $table->integer('leaf_count')->nullable();
    $table->string('condition'); // 'healthy', 'wilted', 'pests'
    $table->text('notes')->nullable();
    $table->string('photo_path')->nullable(); // Path foto
    
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_logs');
    }
};
