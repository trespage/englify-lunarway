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
        if (in_array((int) $user->id_role, [1, 2], true)) {
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
        if (in_array((int) $user->id_role, [1, 2], true)) {
            return true;
        }

        return (int) $user->id_user === (int) $pesan->id_user;
    }

    /**
     * Menghapus pesan: siswa penerima pesan, admin pembuat pesan, atau staf admin.
     */
    public function delete(User $user, PesanAdmin $pesan): bool
    {
        if (in_array((int) $user->id_role, [1, 2], true)) {
            return true;
        }

        return (int) $user->id_user === (int) $pesan->id_user
            || (int) $user->id_user === (int) $pesan->id_admin;
    }
}
