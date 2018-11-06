<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the attachment service.
 */
class AttachmentService extends BaseService implements IAttachmentService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Attachment::class;
    }
}
