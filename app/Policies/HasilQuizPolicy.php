<?php

namespace App\Policies;

use App\Models\HasilQuiz;
use App\Models\User;

class HasilQuizPolicy
{
    /**
     * Tentukan apakah user dapat melihat hasil quiz tertentu.
     * Aturan:
     * - Siswa HANYA bisa melihat hasil kuis miliknya sendiri ($user->id_user === $hasilQuiz->id_user).
     * - Super Admin (id_role 1) dan Admin Divisi (id_role 2) dapat melihat semua hasil kuis.
     */
    public function view(User $user, HasilQuiz $hasilQuiz): bool
    {
        if (in_array((int) $user->id_role, [1, 2], true)) {
            return true;
        }

        return (int) $user->id_user === (int) $hasilQuiz->id_user;
    }

    /**
     * Tentukan apakah user dapat menghapus hasil quiz.
     */
    public function delete(User $user, HasilQuiz $hasilQuiz): bool
    {
        return in_array((int) $user->id_role, [1, 2], true);
    }
}
