<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $email = trim((string) env('SEED_ADMIN_EMAIL', ''));
        $password = (string) env('SEED_ADMIN_PASSWORD', '');

        if ($email === '' && $password === '') {
            return;
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 16) {
            throw new InvalidArgumentException('SEED_ADMIN_EMAIL must be valid and SEED_ADMIN_PASSWORD must contain at least 16 characters.');
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            ['name' => 'Administrator', 'status' => true, 'password' => Hash::make($password)]
        );
        $user->syncRoles(['Admin']);
    }
}
