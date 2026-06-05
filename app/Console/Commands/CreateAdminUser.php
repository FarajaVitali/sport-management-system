<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    // 1. UPDATED: Changed {name} to separate {fname} and {lname} arguments
    protected $signature = 'make:admin {fname} {lname} {email} {password}';

    protected $description = 'Quickly creates a system administrator user account with proper name split';

    public function handle()
    {
        $fname = $this->argument('fname');
        $lname = $this->argument('lname');
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (User::where('email', $email)->exists()) {
            $this->error("A user with the email {$email} already exists!");
            return Command::FAILURE;
        }

        // 2. UPDATED: Supplying both required database structure fields
        User::create([
            'fname'    => $fname,
            'lname'    => $lname,
            'email'    => $email,
            'password' => Hash::make($password),
            'role'     => 'admin', 
        ]);

        $this->info("Admin account successfully created for {$fname} {$lname}!");
        return Command::SUCCESS;
    }
}