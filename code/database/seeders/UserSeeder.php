<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Create user for getting API token
     *
     * Run the database seeds.
     */
    public function run(): void
    {
        $random = random_int(0, 9999);
        $user = User::create([
            'name' => 'test' . $random,
            'email' => 'test' . $random . '@mail.com',
            'password' => Hash::make('test' . $random)
        ]);

        $this->command->info('User test' . $random . ' token is ' . $user->createToken("API TOKEN")->plainTextToken);
    }
}
