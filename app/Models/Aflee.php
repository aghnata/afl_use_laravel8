<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aflee extends Model
{
    public function AFLers()
    {
        return $this->belongsToMany('App\Models\AFLer', 'schedules', 'aflee_id', 'afler_id');
    }
}
