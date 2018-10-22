<?php

namespace App\Importer;

/**
 * Contract that an importer satisfies.
 */
interface IImporter
{
    public function importAssess(string $language);

    public function importLegacyUserData();

    public function importMbct(string $language);

    public function importMbsr(string $language);
}
