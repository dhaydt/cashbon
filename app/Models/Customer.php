<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    protected $fillable = ['name', 'phone', 'password', 'device_token', 'project', 'cashbon'];
}
