<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Afler extends Model
{
    public function AFLees()
    {
        return $this->belongsToMany('App\Models\AFLee', 'schedules', 'afler_id', 'aflee_id');
    }
}
