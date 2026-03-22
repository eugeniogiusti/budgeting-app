<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('translation_key')->nullable()->after('name');
        });

        // Map stored Italian names → translation keys for default categories
        $map = [
            'Affitto'      => 'rent',
            'Spesa'        => 'groceries',
            'Ristoranti'   => 'restaurants',
            'Trasporti'    => 'transport',
            'Bollette'     => 'bills',
            'Divertimento' => 'entertainment',
            'Shopping'     => 'shopping',
            'Risparmi'     => 'savings',
            'Salute'       => 'health',
            'Altro'        => 'other',
        ];

        foreach ($map as $name => $key) {
            DB::table('categories')
                ->where('name', $name)
                ->whereNull('translation_key')
                ->update(['translation_key' => $key]);
        }
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('translation_key');
        });
    }
};
