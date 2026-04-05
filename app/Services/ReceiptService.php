<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReceiptService
{
    // Upload a receipt and attach it to a transaction.
    // Deletes the old file if one already exists.
    public function attach(Transaction $transaction, UploadedFile $file): void
    {
        if ($transaction->receipt_path) {
            Storage::disk('local')->delete($transaction->receipt_path);
        }

        $path = $file->storeAs(
            'receipts',
            Str::uuid() . '.' . $file->getClientOriginalExtension(),
            'local'
        );

        $transaction->update(['receipt_path' => $path]);
    }

    // Delete the receipt file and clear the path on the transaction.
    public function delete(Transaction $transaction): void
    {
        if ($transaction->receipt_path) {
            Storage::disk('local')->delete($transaction->receipt_path);
            $transaction->update(['receipt_path' => null]);
        }
    }

    // Serve the receipt inline in the browser (preview).
    public function preview(Transaction $transaction): BinaryFileResponse
    {
        $this->assertExists($transaction);

        $fullPath = Storage::disk('local')->path($transaction->receipt_path);
        $mime     = Storage::disk('local')->mimeType($transaction->receipt_path);

        return response()->file($fullPath, ['Content-Type' => $mime, 'Content-Disposition' => 'inline']);
    }

    // Force-download the receipt file.
    public function download(Transaction $transaction): BinaryFileResponse
    {
        $this->assertExists($transaction);

        $fullPath = Storage::disk('local')->path($transaction->receipt_path);
        $mime     = Storage::disk('local')->mimeType($transaction->receipt_path);

        return response()->download($fullPath, 'receipt_' . $transaction->id . '.' . pathinfo($transaction->receipt_path, PATHINFO_EXTENSION), ['Content-Type' => $mime]);
    }

    private function assertExists(Transaction $transaction): void
    {
        abort_unless(
            $transaction->receipt_path && Storage::disk('local')->exists($transaction->receipt_path),
            404
        );
    }
}
