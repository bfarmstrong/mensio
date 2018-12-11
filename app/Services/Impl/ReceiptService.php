<?php

namespace App\Services\Impl;

use App\Services\BaseService;
use Barryvdh\DomPDF\PDF as PDFClass;
use Illuminate\Database\Eloquent\Model;
use PDF;
use Storage;

/**
 * Implementation of the receipt service.
 */
class ReceiptService extends BaseService implements IReceiptService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Receipt::class;
    }

    /**
     * Generates a PDF document from a receipt.
     *
     * @param mixed $receipt
     *
     * @return PDFClass
     */
    public function exportAsPdf($receipt)
    {
        $receipt = $this->find($receipt);
        $therapistSignature = Storage::disk(config('filesystems.cloud'))
            ->get($receipt->therapist->written_signature);
        if (! is_null($receipt->clinic->logo)) {
            $logo = Storage::disk(config('filesystems.cloud'))
                ->get($receipt->clinic->logo);
        }
        if (! is_null($receipt->supervisor)) {
            $supervisorSignature = Storage::disk(config('filesystems.cloud'))
                ->get($receipt->supervisor->written_signature);
        }

        return PDF::loadView('pdf.receipt', [
            'logo' => isset($logo) ?
                'data:image/png;base64,'.base64_encode($logo) :
                null,
            'receipt' => $receipt,
            'supervisorSignature' => isset($supervisorSignature) ?
                'data:image/png;base64,'.base64_encode($supervisorSignature) :
                null,
            'therapistSignature' => 'data:image/png;base64,'.
                base64_encode($therapistSignature),
        ]);
    }
}
