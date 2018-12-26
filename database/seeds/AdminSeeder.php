<?php

use App\Models\User;
use App\Services\Impl\UserService;
use Illuminate\Database\Seeder;

/**
 * Seeds the default admin user to the database.
 */
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userService = app(UserService::class);

        $user = $userService->optional()->findBy('email', 'admin@example.com');

        if (is_null($user)) {
            factory(User::class)->create([
                'email' => 'admin@example.com',
                'name' => 'Admin',
            ]);
        }
    }
}
