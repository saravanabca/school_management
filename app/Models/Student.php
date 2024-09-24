<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'mobile', 'email', 'address', 'department_id', 'status'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}