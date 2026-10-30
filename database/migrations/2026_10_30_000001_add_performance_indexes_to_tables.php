<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan indeks basis data pada kolom relasi & filter frekuensi tinggi (S3-07)
     */
    public function up(): void
    {
        // 1. Tabel materi: sering difilter berdasarkan bab, kategori, status (Published/Draft)
        Schema::table('materi', function (Blueprint $table) {
            $table->index('status', 'idx_materi_status');
            $table->index('id_bab', 'idx_materi_id_bab');
            $table->index(['id_bab', 'status'], 'idx_materi_bab_status');
            $table->index(['id_kategori', 'status'], 'idx_materi_kategori_status');
        });

        // 2. Tabel progress_materi: filter user + status ('Started'/'Completed') untuk kalkulasi progress
        Schema::table('progress_materi', function (Blueprint $table) {
            $table->index('status', 'idx_progress_status');
            $table->index(['id_user', 'status'], 'idx_progress_user_status');
        });

        // 3. Tabel quiz: filter bab + status soal aktif
        Schema::table('quiz', function (Blueprint $table) {
            $table->index('status', 'idx_quiz_status');
            $table->index('id_bab', 'idx_quiz_id_bab');
            $table->index(['id_bab', 'status'], 'idx_quiz_bab_status');
        });

        // 4. Tabel hasil_quiz: filter user + quiz dan pengurutan waktu pengerjaan
        Schema::table('hasil_quiz', function (Blueprint $table) {
            $table->index(['id_user', 'id_quiz'], 'idx_hasil_user_quiz');
            $table->index('created_at', 'idx_hasil_created_at');
        });

        // 5. Tabel jawaban_user: agregasi skor/evaluasi jawaban benar per hasil quiz
        Schema::table('jawaban_user', function (Blueprint $table) {
            $table->index(['id_hasil', 'benar'], 'idx_jawaban_hasil_benar');
        });

        // 6. Tabel users: filter berdasarkan role, kategori, dan status aktif
        Schema::table('users', function (Blueprint $table) {
            $table->index('status', 'idx_users_status');
            $table->index(['id_role', 'status'], 'idx_users_role_status');
            $table->index(['id_kategori', 'status'], 'idx_users_kategori_status');
        });

        // 7. Tabel reviews: filter approval ulasan untuk landing page
        if (Schema::hasTable('reviews')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->index('is_approved', 'idx_reviews_approved');
                $table->index(['is_approved', 'created_at'], 'idx_reviews_approved_created');
            });
        }

        // 8. Tabel pesan_admin: filter notifikasi belum dibaca per user
        if (Schema::hasTable('pesan_admin')) {
            Schema::table('pesan_admin', function (Blueprint $table) {
                $table->index('is_read', 'idx_pesan_is_read');
                $table->index(['id_user', 'is_read'], 'idx_pesan_user_read');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->dropIndex('idx_materi_status');
            $table->dropIndex('idx_materi_id_bab');
            $table->dropIndex('idx_materi_bab_status');
            $table->dropIndex('idx_materi_kategori_status');
        });

        Schema::table('progress_materi', function (Blueprint $table) {
            $table->dropIndex('idx_progress_status');
            $table->dropIndex('idx_progress_user_status');
        });

        Schema::table('quiz', function (Blueprint $table) {
            $table->dropIndex('idx_quiz_status');
            $table->dropIndex('idx_quiz_id_bab');
            $table->dropIndex('idx_quiz_bab_status');
        });

        Schema::table('hasil_quiz', function (Blueprint $table) {
            $table->dropIndex('idx_hasil_user_quiz');
            $table->dropIndex('idx_hasil_created_at');
        });

        Schema::table('jawaban_user', function (Blueprint $table) {
            $table->dropIndex('idx_jawaban_hasil_benar');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_status');
            $table->dropIndex('idx_users_role_status');
            $table->dropIndex('idx_users_kategori_status');
        });

        if (Schema::hasTable('reviews')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropIndex('idx_reviews_approved');
                $table->dropIndex('idx_reviews_approved_created');
            });
        }

        if (Schema::hasTable('pesan_admin')) {
            Schema::table('pesan_admin', function (Blueprint $table) {
                $table->dropIndex('idx_pesan_is_read');
                $table->dropIndex('idx_pesan_user_read');
            });
        }
    }
};
