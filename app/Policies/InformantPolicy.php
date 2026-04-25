<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Informant;
use Illuminate\Auth\Access\HandlesAuthorization;

class InformantPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Informant');
    }

    public function view(AuthUser $authUser, Informant $informant): bool
    {
        return $authUser->can('View:Informant');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Informant');
    }

    public function update(AuthUser $authUser, Informant $informant): bool
    {
        return $authUser->can('Update:Informant');
    }

    public function delete(AuthUser $authUser, Informant $informant): bool
    {
        return $authUser->can('Delete:Informant');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Informant');
    }

    public function restore(AuthUser $authUser, Informant $informant): bool
    {
        return $authUser->can('Restore:Informant');
    }

    public function forceDelete(AuthUser $authUser, Informant $informant): bool
    {
        return $authUser->can('ForceDelete:Informant');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Informant');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Informant');
    }

    public function replicate(AuthUser $authUser, Informant $informant): bool
    {
        return $authUser->can('Replicate:Informant');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Informant');
    }

}