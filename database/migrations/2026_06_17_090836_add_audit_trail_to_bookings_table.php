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
            // Menambahkan kolom untuk fitur Jejak Audit (Audit Trail) tanpa patokan after
            $table->string('handled_by')->nullable();
            $table->timestamp('handled_at')->nullable()->after('handled_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            // Menghapus kolom jika sewaktu-waktu dilakukan rollback
            $table->dropColumn(['handled_by', 'handled_at']);
        });
    }
};