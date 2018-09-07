<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! Role::where('name', 'member')->first()) {
            Role::create([
                'name' => 'client',
                'label' => 'Client',
                'level' => 1
            ]);
            Role::create([
                'name' => 'therapist1',
                'label' => 'Jr. Therapist',
                'level' => 2
            ]);
            Role::create([
                'name' => 'therapist2',
                'label' => 'Sr. Therapist',
                'level' => 3
            ]);
            Role::create([
                'name' => 'admin',
                'label' => 'Admin',
                'level' => 4
            ]);
            Role::create([
                'name' => 'superadmin',
                'label' => 'Super Admin',
                'level' => 5
            ]);
        }
    }
}
