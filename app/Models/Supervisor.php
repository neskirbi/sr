<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Supervisor extends Authenticatable
{
    protected $table = 'supervisores';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
