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
      Schema::create('user_plants', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('species_id')->constrained('plant_species');
    
    $table->string('nickname')->nullable(); // "Si Hijau"
    $table->string('location')->default('outdoor'); // indoor/outdoor
    $table->date('planting_date');
    $table->string('status')->default('growing'); // growing, harvested, dead
    
    $table->timestamps();
    $table->softDeletes();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_plants');
    }
};
