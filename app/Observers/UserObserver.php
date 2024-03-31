<?php

namespace App\Observers;

use App\Helpers\LogTypeHelper;
use App\Models\User;
use App\Traits\HasLoggableUpdates;

class UserObserver
{
    use HasLoggableUpdates;

    protected $groupType = User::class;
    protected $groupName = 'USER';

    public function created(User $user)
    {
        $this->logEvent($this->groupName. ' ID:'.$user->id. ' yaratildi', $user, LogTypeHelper::TYPE_SUCCESS);
    }

    public function updated(User $user)
    {
        $this->logEvent($this->groupName. ' ID:'.$user->id. ' tahrirlandi', $user, LogTypeHelper::TYPE_WARNING, true);
    }
}
