<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'nama',
        'email',
        'password',
        'id_role',
        'id_kategori',
        'status',
        'must_change_password',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'must_change_password' => 'boolean',
        'last_login_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function hasilQuiz()
    {
        return $this->hasMany(HasilQuiz::class, 'id_user', 'id_user');
    }

    public function progressMateri()
    {
        return $this->hasMany(ProgressMateri::class, 'id_user');
    }

    public function materiDibuat()
    {
        return $this->hasMany(Materi::class, 'id_admin');
    }

    public function pesanAdmin()
    {
        return $this->hasMany(PesanAdmin::class, 'id_user', 'id_user');
    }

    /**
     * Helpers Cek Role
     */
    public function isSuperAdmin(): bool
    {
        return (int) $this->id_role === 1;
    }

    public function isAdmin(): bool
    {
        return (int) $this->id_role === 2;
    }

    public function isSiswa(): bool
    {
        return (int) $this->id_role === 3;
    }

    public function hasRole(...$roles): bool
    {
        $roleMap = [
            'superadmin'   => 1,
            'super_admin'  => 1,
            'super-admin'  => 1,
            'admin'        => 2,
            'admin_divisi' => 2,
            'admin-divisi' => 2,
            'siswa'        => 3,
            'student'      => 3,
        ];

        foreach ($roles as $r) {
            if (is_array($r)) {
                if ($this->hasRole(...$r)) return true;
            } else {
                $trimmed = strtolower(trim((string)$r));
                $expectedId = is_numeric($trimmed) ? (int)$trimmed : ($roleMap[$trimmed] ?? null);
                if ($expectedId !== null && (int)$this->id_role === $expectedId) {
                    return true;
                }
            }
        }
        return false;
    }
}
