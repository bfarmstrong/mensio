<?php

use App\Services\Impl\IDoctorService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates the default doctor selection for when a client has no doctor.
 */
class AddNoDoctorToDoctorsTable extends Migration
{
    /**
     * The data to add to the database.
     *
     * @var array
     */
    protected $data;

    /**
     * Creates an instance of `AddNoDoctorToDoctorsTable`.
     */
    public function __construct()
    {
        $this->data = ['is_default' => true, 'name' => 'No Doctor'];
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
        });

        $doctorService = app(IDoctorService::class);
        $doctorService->create($this->data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $doctorService = app(IDoctorService::class);
        $doctor = $doctorService
            ->optional()
            ->findBy($this->data);

        if (! is_null($doctor)) {
            $doctorService->delete($doctor);
        }

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });
    }
}
