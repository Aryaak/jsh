<?php

namespace App\Policies;

use App\Models\Expenses;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensesPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Expenses $expenses)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Expenses $expenses)
    {
        //
    }

    public function delete(User $user, Expenses $expenses)
    {
        //
    }

    public function restore(User $user, Expenses $expenses)
    {
        //
    }

    public function forceDelete(User $user, Expenses $expenses)
    {
        //
    }
}
