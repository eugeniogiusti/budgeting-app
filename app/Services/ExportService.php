<?php

namespace App\Services;

use App\Models\Transaction;

// Handles CSV export of all transactions.
class ExportService
{
    // Exports all transactions to a CSV file in storage/app/temp/ and returns the absolute file path.
    // Columns: date, type, amount, category (or '-' for income), note.
    // Column headers are translated using the active locale.
    // The caller is responsible for streaming the file to the browser and deleting it afterwards.
    public function exportCsv(): string
    {
        $transactions = Transaction::with('category')
            ->orderBy('date')
            ->orderBy('id')
            ->get();

        $filename = 'budget-' . date('Y-m-d') . '.csv';
        $dir      = storage_path('app/temp');

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filePath = $dir . '/' . $filename;
        $handle   = fopen($filePath, 'w');

        fputcsv($handle, [
            __('transactions.date'),
            __('transactions.type'),
            __('transactions.amount'),
            __('transactions.category'),
            __('transactions.note'),
        ]);

        foreach ($transactions as $t) {
            fputcsv($handle, [
                $t->date,
                $t->type,
                number_format($t->amount, 2, '.', ''),
                $t->category->name ?? '-',
                $t->note ?? '',
            ]);
        }

        fclose($handle);

        return $filePath;
    }
}
