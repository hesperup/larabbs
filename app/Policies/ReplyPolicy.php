<?php

namespace App\Policies;

use App\Models\Reply;
use App\User as AppUser;

class ReplyPolicy extends Policy
{
    public function update(AppUser $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }

    public function destroy(AppUser $user, Reply $reply)
    {
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
