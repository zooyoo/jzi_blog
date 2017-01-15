<?php
/**
 * Created by PhpStorm.
 * User: zoyo
 * Date: 2017/1/14
 * Time: 13:51
 */

namespace App\Repositories;

use App\User;
use App\Task;

class TaskRepository
{
    public function forUser(User $user){
        return Task::where('user_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();
    }
}