<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('materi', function (Blueprint $table) {
            $table->id('id_materi');
            $table->foreignId('id_kategori')->constrained('kategori', 'id_kategori')->onDelete('cascade');
            $table->foreignId('id_bab')->nullable()->constrained('bab', 'id')->onDelete('set null');
            $table->foreignId('id_admin')->constrained('users', 'id_user')->onDelete('cascade');
            $table->string('judul');
            $table->string('bab', 100)->nullable();
            $table->integer('urutan');
            $table->integer('durasi_menit')->default(15);
            $table->enum('status', ['Draft', 'Published'])->default('Draft');
            $table->text('deskripsi')->nullable();
            $table->longText('isi_materi');
            $table->string('file')->nullable();
            $table->string('gambar')->nullable();
            $table->text('url')->nullable();
            $table->string('audio_url')->nullable();
            $table->text('transcript')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
