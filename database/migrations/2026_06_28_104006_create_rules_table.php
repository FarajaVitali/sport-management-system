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
    Schema::create('rules', function (Blueprint $table) {
        $table->id();
        $table->string('sport'); // NEW: e.g., Football, Basketball, Volleyball
        $table->string('title'); // e.g., "Match Duration"
        $table->text('description'); // e.g., "Matches are 2x20 minutes..."
        $table->string('category')->default('General'); // e.g., "Discipline", "Matchplay"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
