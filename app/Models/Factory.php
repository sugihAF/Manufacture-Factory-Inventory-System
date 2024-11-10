<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Factory extends Authenticatable
{
    use Notifiable;

    protected $guard = 'factory';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function machines()
    {
        return $this->hasMany(Machine::class);
    }
    public function workloads()
    {
        return $this->hasMany(Workload::class);
    }
}
