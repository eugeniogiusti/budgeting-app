<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('emoji', 10)->default('');
            $table->string('color', 7)->default('#6B7280');
            $table->decimal('budget_amount', 10, 2)->default(0);
            $table->boolean('is_goal')->default(false);
            $table->decimal('target_amount', 10, 2)->nullable();
            $table->date('target_date')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();
        DB::table('categories')->insert([
            ['name' => 'Affitto', 'emoji' => '🏠', 'color' => '#EF4444', 'sort_order' => 1, 'is_goal' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Spesa', 'emoji' => '🛒', 'color' => '#F97316', 'sort_order' => 2, 'is_goal' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Ristoranti', 'emoji' => '🍕', 'color' => '#EAB308', 'sort_order' => 3, 'is_goal' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Trasporti', 'emoji' => '🚗', 'color' => '#3B82F6', 'sort_order' => 4, 'is_goal' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Bollette', 'emoji' => '💡', 'color' => '#A855F7', 'sort_order' => 5, 'is_goal' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Divertimento', 'emoji' => '🎉', 'color' => '#EC4899', 'sort_order' => 6, 'is_goal' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Shopping', 'emoji' => '👕', 'color' => '#14B8A6', 'sort_order' => 7, 'is_goal' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Risparmi', 'emoji' => '💰', 'color' => '#22C55E', 'sort_order' => 8, 'is_goal' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Salute', 'emoji' => '🏥', 'color' => '#06B6D4', 'sort_order' => 9, 'is_goal' => false, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Altro', 'emoji' => '❓', 'color' => '#6B7280', 'sort_order' => 10, 'is_goal' => false, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
