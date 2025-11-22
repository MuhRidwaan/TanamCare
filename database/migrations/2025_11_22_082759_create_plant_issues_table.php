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
        Schema::create('plant_issues', function (Blueprint $table) {
    $table->id();
    $table->foreignId('species_id')->nullable()->constrained('plant_species'); // Null = umum
    
    $table->string('problem_name'); // "Kutu Putih"
    $table->text('symptoms');
    $table->text('solution');
    $table->text('prevention')->nullable();
    
    $table->unsignedBigInteger('created_by')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant_issues');
    }
};
