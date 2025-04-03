<?php

declare(strict_types=1);

namespace App\Http\Controllers\PDFGenerator;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileUpload\FileUploadRequest;
use App\Services\PDF\FlightReportPdfService;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class PDFGeneratorController extends Controller
{
    /**
     * Generate PDF file from txt files.
     */
    public function generate(FileUploadRequest $request, FlightReportPdfService $service): StreamedResponse
    {
        $file = $request->file('files')[0];

        $pdfContent = $service->generateFromFile($file);

        $filename = sprintf('%s.pdf', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

        return response()->streamDownload(fn () => print ($pdfContent), $filename);
    }
}
