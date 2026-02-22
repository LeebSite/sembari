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
        Schema::table('reading_levels', function (Blueprint $table) {
            if (!Schema::hasColumn('reading_levels', 'description')) {
                $table->text('description')->nullable()->after('order');
            }
            if (!Schema::hasColumn('reading_levels', 'icon')) {
                $table->string('icon')->nullable()->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reading_levels', function (Blueprint $table) {
            $table->dropColumn(['description', 'icon']);
        });
    }
};
