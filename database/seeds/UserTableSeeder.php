<?php

use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service = app(UserService::class);

        if (!User::where('email', 'admin@example.com')->first()) {
            $user = User::create([
                'firstname' => 'Admin',
                'lastname' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin')
            ]);

            $service->create($user, 'admin', 'admin', false);
            $user->meta->update([
                'is_active' => true,
            ]);
        }

        if (!User::where('email', 'superadmin@example.com')->first()) {
            $user = User::create([
                'firstname' => 'Super Admin',
                'lastname' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => bcrypt('superadmin')
            ]);

            $service->create($user, 'admin', 'admin', false);
            $user->meta->update([
                'is_active' => true,
            ]);
        }

    }
}
