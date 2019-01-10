<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the Document service.
 */
class DocumentService extends BaseService implements IDocumentService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Document::class;
    }
}
