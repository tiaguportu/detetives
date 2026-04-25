<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Clue;
use Illuminate\Auth\Access\HandlesAuthorization;

class CluePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Clue');
    }

    public function view(AuthUser $authUser, Clue $clue): bool
    {
        return $authUser->can('View:Clue');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Clue');
    }

    public function update(AuthUser $authUser, Clue $clue): bool
    {
        return $authUser->can('Update:Clue');
    }

    public function delete(AuthUser $authUser, Clue $clue): bool
    {
        return $authUser->can('Delete:Clue');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Clue');
    }

    public function restore(AuthUser $authUser, Clue $clue): bool
    {
        return $authUser->can('Restore:Clue');
    }

    public function forceDelete(AuthUser $authUser, Clue $clue): bool
    {
        return $authUser->can('ForceDelete:Clue');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Clue');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Clue');
    }

    public function replicate(AuthUser $authUser, Clue $clue): bool
    {
        return $authUser->can('Replicate:Clue');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Clue');
    }

}