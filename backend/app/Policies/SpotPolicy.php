<?php

namespace App\Policies;

use App\Models\Spot;
use App\Models\User;

class SpotPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Spot $spot): bool
    {
        // For now, anyone can suggest edits or only admins.
        // Let's assume only admins can directly update approved spots,
        // or we allow anyone to submit updates that go back to PENDING.
        // For simplicity, let's say only ADMIN can update or delete.
        return $user->role->value === 'ADMIN';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Spot $spot): bool
    {
        return $user->role->value === 'ADMIN';
    }
}
