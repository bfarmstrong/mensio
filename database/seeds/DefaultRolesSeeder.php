<?php

use App\Models\Role;
use App\Services\Impl\RoleService;
use Illuminate\Database\Seeder;

/**
 * Seeds the default roles to the database.
 */
class DefaultRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleService = app(RoleService::class);

        if (is_null($roleService->findBy('name', 'client'))) {
            factory(Role::class)->create([
                'label' => 'Client',
                'level' => 1,
                'name' => 'client',
                'protected' => true,
            ]);
        }

        $roleService->resetCriteria();
        if (is_null($roleService->findBy('name', 'therapist1'))) {
            factory(Role::class)->create([
                'label' => 'Jr. Therapist',
                'level' => 2,
                'name' => 'therapist1',
                'protected' => true,
            ]);
        }

        $roleService->resetCriteria();
        if (is_null($roleService->findBy('name', 'therapist2'))) {
            factory(Role::class)->create([
                'label' => 'Sr. Therapist',
                'level' => 3,
                'name' => 'therapist2',
                'protected' => true,
            ]);
        }

        $roleService->resetCriteria();
        if (is_null($roleService->findBy('name', 'admin'))) {
            factory(Role::class)->create([
                'label' => 'Admin',
                'level' => 4,
                'name' => 'admin',
                'protected' => true,
            ]);
        }

        $roleService->resetCriteria();
        if (is_null($roleService->findBy('name', 'superadmin'))) {
            factory(Role::class)->create([
                'label' => 'Super Admin',
                'level' => 5,
                'name' => 'superadmin',
                'protected' => true,
            ]);
        }
    }
}
