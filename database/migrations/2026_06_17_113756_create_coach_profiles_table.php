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
   Schema::create('coach_profiles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('college_id')->constrained()->onDelete('cascade');
    
    // CHANGED: Nullable allows the team to exist first without a coach
    $table->foreignId('team_id')->nullable()->constrained()->onDelete('set null');
    
    $table->string('phone_number');
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coach_profiles');
    }
};
