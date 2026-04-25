<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Investigator;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvestigatorPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Investigator');
    }

    public function view(AuthUser $authUser, Investigator $investigator): bool
    {
        return $authUser->can('View:Investigator');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Investigator');
    }

    public function update(AuthUser $authUser, Investigator $investigator): bool
    {
        return $authUser->can('Update:Investigator');
    }

    public function delete(AuthUser $authUser, Investigator $investigator): bool
    {
        return $authUser->can('Delete:Investigator');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Investigator');
    }

    public function restore(AuthUser $authUser, Investigator $investigator): bool
    {
        return $authUser->can('Restore:Investigator');
    }

    public function forceDelete(AuthUser $authUser, Investigator $investigator): bool
    {
        return $authUser->can('ForceDelete:Investigator');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Investigator');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Investigator');
    }

    public function replicate(AuthUser $authUser, Investigator $investigator): bool
    {
        return $authUser->can('Replicate:Investigator');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Investigator');
    }

}