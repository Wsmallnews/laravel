<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    // public function before($user, $ability)
    // {
    //     if ($user->isSuperAdmin()) {
    //         return true;
    //     }
    // }


    /**
     * Determine whether the user can view the topic.
     *
     * @param  App\User  $user
     * @param  App\Topic  $topic
     * @return mixed
     */
    public function view(User $user, Topic $topic)
    {
        //
    }

    /**
     * Determine whether the user can create topics.
     *
     * @param  App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        
    }

    /**
     * Determine whether the user can update the topic.
     *
     * @param  App\User  $user
     * @param  App\Topic  $topic
     * @return mixed
     */
    public function update(User $user, Topic $topic)
    {
        
    }

    /**
     * Determine whether the user can delete the topic.
     *
     * @param  App\User  $user
     * @param  App\Topic  $topic
     * @return mixed
     */
    public function delete(User $user, Topic $topic)
    {
        //
    }
}
