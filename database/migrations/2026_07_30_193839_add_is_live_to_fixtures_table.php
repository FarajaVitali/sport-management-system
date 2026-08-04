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
    Schema::table('fixtures', function (Blueprint $table) {
        if (!Schema::hasColumn('fixtures', 'is_live')) {
            $table->boolean('is_live')->default(false);
        }
    });
}

public function down(): void
{
    Schema::table('fixtures', function (Blueprint $table) {
        if (Schema::hasColumn('fixtures', 'is_live')) {
            $table->dropColumn('is_live');
        }
    });
}
};
