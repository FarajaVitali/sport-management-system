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
    Schema::table('teams', function (Blueprint $table) {
        // Adds a 'points' integer column that defaults to 0
        $table->integer('points')->default(0)->after('name'); 
    });
}

public function down()
{
    Schema::table('teams', function (Blueprint $table) {
        $table->dropColumn('points');
    });
}
};
