<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     */
    protected $description = 'Safely provisions a system administrator account from the console terminal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('--- Creates an administrative account ---');

        // 1. Gather interactive inputs
        $name = $this->ask('Enter Administrator Name');
        $mobileNumber = $this->ask('Enter Mobile Number (10 digits)');
        $email = $this->ask('Enter Email Address');

        // 2. Validate input pattern basics inline
        if (!preg_match('/^[0-9]{10}$/', $mobileNumber)) {
            $this->error('Aborted: Mobile number must be exactly 10 digits.');
            return Command::FAILURE;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Aborted: Invalid email address format.');
            return Command::FAILURE;
        }

        // 3. Defensive check: Prevent duplicate identity conflicts
        $mobileExists = User::where('mobile_number', $mobileNumber)->exists();
        if ($mobileExists) {
            $this->error("Aborted: A user record with the number {$mobileNumber} already exists.");
            return Command::FAILURE;
        }

        $emailExists = User::where('email', $email)->exists();
        if ($emailExists) {
            $this->error("Aborted: A user record with the email {$email} already exists.");
            return Command::FAILURE;
        }

        // 4. Create the system profile directly with the 'admin' role
        $user = new User();
        $user->name = $name;
        $user->mobile_number = $mobileNumber;
        $user->email = $email;
        $user->role = 'admin';  // Bypasses fillable rules completely
        $user->is_active = true;
        $user->save();

        $this->info("Success: Administrative profile created for {$user->name} ({$user->email}) with mobile number ({$user->mobile_number}).");
        
        return Command::SUCCESS;
    }
}
