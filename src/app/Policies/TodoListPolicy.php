<?php

namespace App\Policies;

use App\User;
use App\Models\TodoList;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoListPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can update the modelsTodoList.
     *
     * @param  \App\User  $user
     * @param  \App\Models\TodoList  $todoList
     * @return mixed
     */
    public function update(User $user, TodoList $todoList)
    {
        return $user->id === $todoList->user_id;
    }

    /**
     * Determine whether the user can delete the modelsTodoList.
     *
     * @param  \App\User  $user
     * @param  \App\Models\TodoList  $modelsTodoList
     * @return mixed
     */
    public function delete(User $user, TodoList $todoList)
    {
        return $user->id === $todoList->user_id;
    }
}
