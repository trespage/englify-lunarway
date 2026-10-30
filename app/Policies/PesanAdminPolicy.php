<?php

namespace App\Policies;

use App\Models\PesanAdmin;
use App\Models\User;

class PesanAdminPolicy
{
    /**
     * Siswa hanya bisa melihat pesan miliknya sendiri.
     * Admin pengirim atau Super Admin juga berhak melihat.
     */
    public function view(User $user, PesanAdmin $pesan): bool
    {
        if ((int) $user->id_role === 1) {
            return true;
        }

        return (int) $user->id_user === (int) $pesan->id_user
            || (int) $user->id_user === (int) $pesan->id_admin;
    }

    /**
     * Menandai pesan sebagai sudah dibaca: hanya siswa penerima pesan.
     */
    public function update(User $user, PesanAdmin $pesan): bool
    {
        return (int) $user->id_user === (int) $pesan->id_user;
    }

    /**
     * Menghapus pesan: siswa penerima pesan atau pembuat pesan.
     */
    public function delete(User $user, PesanAdmin $pesan): bool
    {
        if ((int) $user->id_role === 1) {
            return true;
        }

        return (int) $user->id_user === (int) $pesan->id_user
            || (int) $user->id_user === (int) $pesan->id_admin;
    }
}
