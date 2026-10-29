<?php

namespace App\Policies;

use App\Models\Tournament;
use App\Models\User;

class TournamentPolicy
{
    /**
     * Cek apakah user adalah pemilik turnamen ini.
     */
    private function isOwner(User $user, Tournament $tournament): bool
    {
        return $user->id === $tournament->id_penyelenggara;
    }

    public function view(User $user, Tournament $tournament): bool
    {
        return $this->isOwner($user, $tournament);
    }

    public function update(User $user, Tournament $tournament): bool
    {
        return $this->isOwner($user, $tournament);
    }

    public function delete(User $user, Tournament $tournament): bool
    {
        return $this->isOwner($user, $tournament);
    }
}