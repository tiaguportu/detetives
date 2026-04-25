<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CountryCuriosity;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryCuriosityPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CountryCuriosity');
    }

    public function view(AuthUser $authUser, CountryCuriosity $countryCuriosity): bool
    {
        return $authUser->can('View:CountryCuriosity');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CountryCuriosity');
    }

    public function update(AuthUser $authUser, CountryCuriosity $countryCuriosity): bool
    {
        return $authUser->can('Update:CountryCuriosity');
    }

    public function delete(AuthUser $authUser, CountryCuriosity $countryCuriosity): bool
    {
        return $authUser->can('Delete:CountryCuriosity');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:CountryCuriosity');
    }

    public function restore(AuthUser $authUser, CountryCuriosity $countryCuriosity): bool
    {
        return $authUser->can('Restore:CountryCuriosity');
    }

    public function forceDelete(AuthUser $authUser, CountryCuriosity $countryCuriosity): bool
    {
        return $authUser->can('ForceDelete:CountryCuriosity');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CountryCuriosity');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CountryCuriosity');
    }

    public function replicate(AuthUser $authUser, CountryCuriosity $countryCuriosity): bool
    {
        return $authUser->can('Replicate:CountryCuriosity');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CountryCuriosity');
    }

}