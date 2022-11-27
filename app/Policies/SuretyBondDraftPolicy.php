<?php

namespace App\Policies;

use App\Models\SuretyBondDraft;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuretyBondDraftPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, SuretyBondDraft $suretyBondDraft)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, SuretyBondDraft $suretyBondDraft)
    {
        //
    }

    public function delete(User $user, SuretyBondDraft $suretyBondDraft)
    {
        //
    }

    public function restore(User $user, SuretyBondDraft $suretyBondDraft)
    {
        //
    }

    public function forceDelete(User $user, SuretyBondDraft $suretyBondDraft)
    {
        //
    }
}
