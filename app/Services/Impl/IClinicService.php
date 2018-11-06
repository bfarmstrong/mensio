<?php

namespace App\Services\Impl;

use App\Services\IBaseService;

/**
 * Interface for the Clinic service.
 */
interface IClinicService extends IBaseService
{
    public function switchBackClinic();

    public function switchToClinic(string $id,string $clinic_id);
}
