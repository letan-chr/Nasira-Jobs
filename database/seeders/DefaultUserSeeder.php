<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'super@admin.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make(self::adminPassword()),
            'phone' => '7878454512',
            'is_default' => 1,
        ];

        $user = User::create($input);
    }

    private static function adminPassword(): string
    {
        $password = (string) env('DEFAULT_ADMIN_PASSWORD', '');

        if ($password === '' || strtolower($password) === 'password') {
            throw new \RuntimeException(
                'Set a strong DEFAULT_ADMIN_PASSWORD in .env before seeding (do not use "password").'
            );
        }

        return $password;
    }
}
