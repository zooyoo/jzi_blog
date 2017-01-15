<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Task
 *
 * @mixin \Eloquent
 */
class Task extends Model
{
    protected $fillable = ['name'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
