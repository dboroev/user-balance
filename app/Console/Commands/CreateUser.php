<?php

namespace App\Console\Commands;
use App\Models\User;
use App\Models\Balance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command {
    protected $signature = 'user:create {email} {password}';
    protected $description = 'Create a new user';

    public function handle(): void
    {
        $user = User::query()->create([
            'email' => $this->argument('email'),
            'password' => Hash::make($this->argument('password'))
        ]);

        Balance::query()->create(['user_id' => $user->id]);

        $this->info("User created successfully with ID: {$user->id}");
    }
}
