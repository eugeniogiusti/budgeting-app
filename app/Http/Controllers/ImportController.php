<?php

namespace App\Http\Controllers;

use App\Services\ImportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImportController extends Controller
{
    public function __construct(private ImportService $importService) {}

    // Show the import page.
    public function index(): View
    {
        return view('import.index');
    }

    // Handle CSV import from a file upload or pasted text content. Duplicates are skipped by the service.
    public function store(Request $request): RedirectResponse
    {
        if ($request->input('mode') === 'paste') {
            $request->validate(['content' => ['required', 'string']]);

            $tmpPath = tempnam(sys_get_temp_dir(), 'csv_import_');
            file_put_contents($tmpPath, $request->input('content'));
            $filePath = $tmpPath;
        } else {
            $request->validate(['file' => ['required', 'file', 'mimes:csv,txt', 'max:2048']]);

            $filePath = $request->file('file')->getRealPath();
        }

        $result = $this->importService->importFromFile($filePath);

        return redirect()->route('settings.index')
            ->with('import_result', __('ui.import_result', $result));
    }
}
