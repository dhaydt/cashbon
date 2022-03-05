<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Approver extends Model
{
    use HasFactory;
    use HasApiTokens;
    protected $fillable = [
        'name',
        'phone',
        'password',
        'project',
        'device_token',
    ];
}
