<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashbon extends Model
{
    use HasFactory;

    public function pekerja()
    {
        return $this->belongsTo(Customer::class, 'pekerja_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function approver()
    {
        return $this->belongsTo(Approver::class, 'approver_id');
    }
}
