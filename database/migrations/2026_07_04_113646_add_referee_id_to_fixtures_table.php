<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // DO NOTHING. 
        // The column already exists in MySQL, we just need Laravel to pass this file.
    }

    public function down(): void
    {
        // Do nothing here either
    }
};