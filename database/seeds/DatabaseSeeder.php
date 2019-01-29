<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(DefaultClinicSeeder::class);
        $this->call(DefaultRolesSeeder::class);
        $this->call(AdminSeeder::class);

        Model::reguard();
    }
}
