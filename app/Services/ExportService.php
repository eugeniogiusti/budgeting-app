<?php

namespace App\Services;

use App\Models\Transaction;

class ExportService
{
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
            __('ui.date'),
            __('ui.type'),
            __('ui.amount'),
            __('ui.category'),
            __('ui.note'),
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
