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
    Schema::create('fixtures', function (Blueprint $table) {
        $table->id();
        $table->foreignId('home_team_id')->constrained('teams')->onDelete('cascade');
        $table->foreignId('away_team_id')->constrained('teams')->onDelete('cascade');
        $table->integer('round_number')->default(1); // Track match weeks/days
        $table->dateTime('match_date')->nullable();
        $table->string('venue')->nullable();
        $table->string('status')->default('scheduled'); // scheduled, live, completed
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
