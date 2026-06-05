<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('teams', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();
        $table->foreignId('college_id')->constrained()->onDelete('cascade');
        
        // REMOVE OR COMMENT OUT THIS LINE:
        // $table->foreignId('sport_id')->constrained()->onDelete('cascade');
        
        $table->string('coach_name')->default('TBD');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};