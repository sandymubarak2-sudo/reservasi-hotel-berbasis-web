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
        Schema::table('booking', function (Blueprint $table) {
            // Menambahkan kolom bukti_pembayaran yang boleh kosong
            $table->string('bukti_pembayaran')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            // Menghapus kolom jika melakukan rollback
            $table->dropColumn('bukti_pembayaran');
        });
    }
};