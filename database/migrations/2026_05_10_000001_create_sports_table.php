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
    Schema::create('sports', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // e.g., Football, Basketball
        $table->timestamps();
    });
} // <-- This closing brace was likely missing or misplaced!

    public function down(): void
    {
        Schema::dropIfExists('sports');
    }
};