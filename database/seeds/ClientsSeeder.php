<?php

use App\Models\User;
use App\Services\Impl\RoleService;
use Illuminate\Database\Seeder;

/**
 * Seeds a number of clients and therapists.
 */
class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleService = app(RoleService::class);
        $clientRole = $roleService
            ->optional()
            ->findBy('name', 'client');
        $therapist1Role = $roleService
            ->optional()
            ->findBy('name', 'therapist1');

        factory(User::class, 5)
            ->create([
                'role_id' => $therapist1Role->id,
            ])
            ->each(function (User $user) use ($clientRole) {
                $user
                    ->patients()
                    ->sync(
                        factory(User::class, 3)->create([
                            'role_id' => $clientRole->id,
                        ])
                    );
            });
    }
}
