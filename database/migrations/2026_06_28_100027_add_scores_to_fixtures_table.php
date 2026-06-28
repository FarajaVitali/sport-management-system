<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('fixtures', function (Blueprint $table) {
        $table->integer('home_score')->default(0);
        $table->integer('away_score')->default(0);
        // If you haven't added started_at yet, add it here too:
        if (!Schema::hasColumn('fixtures', 'started_at')) {
            $table->timestamp('started_at')->nullable();
        }
    });
}

public function down(): void
{
    Schema::table('fixtures', function (Blueprint $table) {
        $table->dropColumn(['home_score', 'away_score', 'started_at']);
    });
}
    
};
