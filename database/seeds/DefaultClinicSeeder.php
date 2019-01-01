<?php

use App\Models\Clinic;
use App\Services\Impl\IClinicService;
use Illuminate\Database\Seeder;

/**
 * Seeds the default clinic to the database.
 */
class DefaultClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clinicService = app(IClinicService::class);
        $clinic = $clinicService->optional()->findBy('name', 'Mindspace');

        if (is_null($clinic)) {
            factory(Clinic::class)->create([
                'name' => 'Mindspace',
                'subdomain' => 'mindspace',
            ]);
        }
    }
}
