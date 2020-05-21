<?php

namespace App\Observers;

use App\User;
use PhpParser\Node\Expr\Empty_;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function creating(User $user)
    {
        //
    }

    public function updating(User $user)
    {
        //
    }

    public function saving(User $user)
    {
        if (empty($user->avatar)) {
            $user->avatar = 'http://larabbs.test/uploads/images/avatars/202005/20/10_1589988212-yojCFozTXK.jpg';
        }
    }
}
