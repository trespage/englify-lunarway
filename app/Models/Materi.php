<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';
    protected $primaryKey = 'id_materi';

    protected $fillable = [
        'id_kategori',
        'id_bab',
        'id_admin',
        'judul',
        'bab',
        'urutan',
        'durasi_menit',
        'status',
        'deskripsi',
        'isi_materi',
        'file',
        'gambar',
        'url',
        'audio_url',
        'transcript',
    ];

    protected $casts = [
        'durasi_menit' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function ($materi) {
            if (empty($materi->bab)) {
                if (!empty($materi->id_bab)) {
                    $bab = Bab::find($materi->id_bab);
                    $materi->bab = $bab ? $bab->judul : 'Bab ' . $materi->id_bab;
                } else {
                    $materi->bab = '-';
                }
            }
        });
    }

    /**
     * Aksesor untuk mendapatkan array seluruh URL materi
     * Kompatibel dengan format legacy (single string) dan format baru (JSON array)
     */
    public function getUrlsListAttribute(): array
    {
        if (empty($this->url)) {
            return [];
        }

        if (is_array($this->url)) {
            return array_values(array_filter(array_map('trim', $this->url)));
        }

        $decoded = json_decode($this->url, true);
        if (is_array($decoded)) {
            return array_values(array_filter(array_map('trim', $decoded)));
        }

        $trimmed = trim((string) $this->url);
        return $trimmed !== '' ? [$trimmed] : [];
    }

    /**
     * Scope materi yang aktif dan dapat dilihat siswa:
     * 1. Status materi Published / Aktif (bukan Draft)
     * 2. Bab induknya harus aktif (is_active = true)
     */
    public function scopeVisibleForSiswa($query)
    {
        return $query->where(function ($q) {
                $q->where('status', 'Published')
                  ->orWhere('status', 'Aktif');
            })
            ->whereHas('babModel', function ($q) {
                $q->where('is_active', true);
            });
    }

    public function scopePublished($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'Published')->orWhere('status', 'Aktif');
        });
    }

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // Relasi ke Bab
    public function babModel()
    {
        return $this->belongsTo(Bab::class, 'id_bab', 'id');
    }

    // Relasi ke Admin pembuat
    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_user');
    }

    // Relasi ke Quiz
    public function quiz()
    {
        return $this->hasMany(Quiz::class, 'id_materi', 'id_materi');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'id_materi', 'id_materi');
    }

    // Relasi ke Progress siswa
    public function progress()
    {
        return $this->hasMany(ProgressMateri::class, 'id_materi', 'id_materi');
    }

    // Alias konten agar kompatibel dengan template lama
    public function getKontenAttribute()
    {
        return $this->isi_materi;
    }

    /**
     * Cek apakah materi ini sudah diselesaikan oleh siswa tertentu
     * Kriteria:
     * - Jika materi memiliki kuis: Siswa telah menyelesaikan kuisnya (ada di HasilQuiz).
     * - Jika materi tidak memiliki kuis: Siswa telah membaca materinya (ProgressMateri = Completed).
     */
    public function isSelesaiBy($userId): bool
    {
        $hasQuizzes = $this->relationLoaded('quiz') 
            ? $this->quiz->isNotEmpty() 
            : $this->quiz()->exists();

        if ($hasQuizzes) {
            $quizIds = $this->relationLoaded('quiz') 
                ? $this->quiz->pluck('id_quiz')->all() 
                : $this->quiz()->pluck('id_quiz')->all();

            return HasilQuiz::where('id_user', $userId)
                ->whereIn('id_quiz', $quizIds)
                ->exists();
        }

        return ProgressMateri::where('id_user', $userId)
            ->where('id_materi', $this->id_materi)
            ->where('status', 'Completed')
            ->exists();
    }

    /**
     * Cek apakah materi ini terkunci untuk siswa tertentu di dalam bab-nya
     * Materi ke-1 dalam Bab selalu terbuka.
     * Materi ke-n (n > 1) terbuka jika materi ke-(n-1) di bab yang sama sudah selesai.
     */
    public function isLockedBy($userId, ?Materi $materiSebelumnya = null): array
    {
        if ($materiSebelumnya === null) {
            $materiSebelumnya = self::visibleForSiswa()
                ->where('id_bab', $this->id_bab)
                ->where(function ($q) {
                    $q->where('urutan', '<', $this->urutan)
                      ->orWhere(function ($q2) {
                          $q2->where('urutan', $this->urutan)
                             ->where('id_materi', '<', $this->id_materi);
                      });
                })
                ->orderByDesc('urutan')
                ->orderByDesc('id_materi')
                ->first();
        }

        if (!$materiSebelumnya) {
            return [
                'is_locked'         => false,
                'materi_sebelumnya' => null,
            ];
        }

        $prevSelesai = $materiSebelumnya->isSelesaiBy($userId);

        return [
            'is_locked'         => !$prevSelesai,
            'materi_sebelumnya' => $materiSebelumnya,
        ];
    }
}
