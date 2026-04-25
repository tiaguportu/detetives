<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\IntroStory;
use Illuminate\Auth\Access\HandlesAuthorization;

class IntroStoryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:IntroStory');
    }

    public function view(AuthUser $authUser, IntroStory $introStory): bool
    {
        return $authUser->can('View:IntroStory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:IntroStory');
    }

    public function update(AuthUser $authUser, IntroStory $introStory): bool
    {
        return $authUser->can('Update:IntroStory');
    }

    public function delete(AuthUser $authUser, IntroStory $introStory): bool
    {
        return $authUser->can('Delete:IntroStory');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:IntroStory');
    }

    public function restore(AuthUser $authUser, IntroStory $introStory): bool
    {
        return $authUser->can('Restore:IntroStory');
    }

    public function forceDelete(AuthUser $authUser, IntroStory $introStory): bool
    {
        return $authUser->can('ForceDelete:IntroStory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:IntroStory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:IntroStory');
    }

    public function replicate(AuthUser $authUser, IntroStory $introStory): bool
    {
        return $authUser->can('Replicate:IntroStory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:IntroStory');
    }

}