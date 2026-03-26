<?php

namespace App\Http\Controllers;

use App\Services\ExportService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    public function __construct(private ExportService $exportService) {}

    // Generate and stream a CSV file containing all transactions.
    public function csv(): BinaryFileResponse
    {
        $filePath = $this->exportService->exportCsv();
        $filename = basename($filePath);

        return response()->download($filePath, $filename, ['Content-Type' => 'text/csv']);
    }
}
