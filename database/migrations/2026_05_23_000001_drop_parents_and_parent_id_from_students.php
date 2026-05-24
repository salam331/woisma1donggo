<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Hapus relasi parent_id di students
        if (Schema::hasTable('students') && Schema::hasColumn('students', 'parent_id')) {
            Schema::table('students', function (Blueprint $table) {
                // dropForeign lebih aman dilakukan dengan try/catch karena nama constraint bisa berbeda-beda
                try {
                    $table->dropForeign(['parent_id']);
                } catch (\Throwable $e) {
                    // no-op
                }

                $table->dropColumn('parent_id');
            });
        }

        // 2) Hapus tabel parents (data orang tua sekaligus)
        if (Schema::hasTable('parents')) {
            Schema::dropIfExists('parents');
        }
    }

    public function down(): void
    {
        // Karena permintaan user: fokus hapus data/kolom/tabel terkait parents,
        // maka rollback tidak dipaksakan untuk mengembalikan skema lengkap.
        // (Agar aman, implementasi down dibiarkan kosong.)
    }
};

