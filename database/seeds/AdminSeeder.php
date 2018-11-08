<?php

use App\Models\User;
use App\Services\Impl\RoleService;
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
        $roleService = app(RoleService::class);
        $userService = app(UserService::class);

        $user = $userService->optional()->findBy('email', 'admin@example.com');
        $role = $roleService->optional()->findBy('name', 'superadmin');

        if (is_null($user) && ! is_null($role)) {
            factory(User::class)->create([
                'email' => 'admin@example.com',
                'name' => 'Admin',
                'role_id' => $role->id,
            ]);
        }
    }
}
