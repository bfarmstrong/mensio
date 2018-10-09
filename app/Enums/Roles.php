<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Enumerated type which contains the list of roles and their associated
 * levels.  New roles created in the database will have one of these levels.
 */
final class Roles extends Enum
{
    const Client = 1;
    const JuniorTherapist = 2;
    const SeniorTherapist = 3;
    const Administrator = 4;
    const Super = 5;
}
