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
        Schema::table('player_profiles', function (Blueprint $table) {
            // Health & Availability
            $table->string('physical_status')->default('Fit'); // Fit, Injured, Benched, Suspended
            
            // Player Statistics
            $table->integer('goals')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('yellow_cards')->default(0);
            $table->integer('red_cards')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('player_profiles', function (Blueprint $table) {
            $table->dropColumn(['physical_status', 'goals', 'assists', 'yellow_cards', 'red_cards']);
        });
    }
};
