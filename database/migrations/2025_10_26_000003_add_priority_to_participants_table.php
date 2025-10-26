<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->boolean('priority')->default(false)->after('is_winner');
            $table->foreignId('priority_category_id')->nullable()->constrained('categories')->nullOnDelete()->after('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropForeign(['priority_category_id']);
            $table->dropColumn(['priority_category_id', 'priority']);
        });
    }
};
