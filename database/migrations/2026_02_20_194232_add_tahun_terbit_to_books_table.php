<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Tambahkan kolom tahun_terbit setelah kolom 'license'
            // Nullable agar buku lama tidak error
            $table->smallInteger('tahun_terbit')->nullable()->after('license');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('tahun_terbit');
        });
    }
};
