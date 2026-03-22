<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Transaction;

class ImportService
{
    /**
     * Imports transactions from a CSV file path.
     * Returns ['imported' => int, 'skipped' => int].
     */
    public function importFromFile(string $filePath): array
    {
        $handle     = fopen($filePath, 'r');
        $categories = Category::pluck('id', 'name');
        $imported   = 0;
        $skipped    = 0;

        fgetcsv($handle); // skip header

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 4) {
                continue;
            }

            [$date, $type, $amount, $categoryName, $note] = array_pad($row, 5, null);

            $date   = trim($date);
            $type   = trim($type);
            $amount = (float) trim($amount);
            $note   = trim($note ?? '');

            if (! in_array($type, ['income', 'expense'])) {
                $skipped++;
                continue;
            }

            $categoryId = $categoryName !== '-'
                ? ($categories[trim($categoryName)] ?? null)
                : null;

            $exists = Transaction::where('date', $date)
                ->where('type', $type)
                ->where('amount', $amount)
                ->where('category_id', $categoryId)
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            Transaction::create([
                'date'        => $date,
                'type'        => $type,
                'amount'      => $amount,
                'category_id' => $categoryId,
                'note'        => $note ?: null,
            ]);

            $imported++;
        }

        fclose($handle);

        return ['imported' => $imported, 'skipped' => $skipped];
    }
}
