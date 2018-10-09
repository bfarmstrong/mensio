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

        $this->call(DefaultRolesSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ClientsSeeder::class);
        $this->call(QuestionnairesSeeder::class);

        Model::reguard();
    }
}
