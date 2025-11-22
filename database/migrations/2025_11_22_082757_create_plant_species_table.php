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
        Schema::create('plant_species', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // Contoh: "Monstera", "Cabai Rawit"
    $table->string('scientific_name')->nullable();
    $table->text('description')->nullable();
    
    // Panduan Perawatan
    $table->integer('optimal_temp_min')->nullable();
    $table->integer('optimal_temp_max')->nullable();
    $table->integer('watering_frequency_days')->default(1); // Interval hari siram
    $table->string('sunlight_requirement')->nullable(); // 'full_sun', 'shade'
    
    // Audit
    $table->unsignedBigInteger('created_by')->nullable();
    $table->unsignedBigInteger('updated_by')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_species');
    }
};
