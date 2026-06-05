<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('fname');
        $table->string('lname');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->string('role')->default('player');
        
        // ADD THIS LINE: Sets up a string status column with 'pending' as default
        $table->string('status')->default('pending'); 
        
        $table->rememberToken();
        $table->timestamps();
    });
}
};