<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            // Add index for is_winner since we query it frequently
            $table->index('is_winner');

            // Add index for bib_number for faster searches
            // Note: MySQL automatically creates index for unique columns,
            // but we'll add it explicitly for other DBs
            if (DB::getDriverName() !== 'mysql') {
                $table->index('bib_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropIndex(['is_winner']);
            if (DB::getDriverName() !== 'mysql') {
                $table->dropIndex(['bib_number']);
            }
        });
    }
};
