<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdministrator extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'create:administrator';

    /**
     * The console command description.
     */
    protected $description = 'Safely provisions a system administrative account from the console terminal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('--- Creates a system administrative account ---');

        $email = $this->ask('Enter Email Address');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Aborted: Invalid email address format.');

            return Command::FAILURE;
        }

        if (User::where('email', $email)->exists()) {
            $this->error("Aborted: An administrator with the email {$email} already exists.");

            return Command::FAILURE;
        }

        $name = $this->ask('Enter Name');
        $password = Str::random(16);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->info("Generated password: {$password}");
        $this->info("Success: Administrative account created for {$user->email}.");

        return Command::SUCCESS;
    }
}
