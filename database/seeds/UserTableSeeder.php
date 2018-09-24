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

        if (! User::where('name', 'admin')->first()) {
            $user = User::create([
                'email' => 'admin@example.com',
                'name' => 'Admin',
                'is_active' => true,
                'password' => bcrypt('admin'),
            ]);

            $service->create($user, 'admin', 'admin', false);
        }
    }
}
