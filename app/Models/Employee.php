<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'employee_id';
    protected $fillable = ['name', 'department', 'plate_number'];

    public function visits()
    {
        return $this->hasMany(Visit::class, 'employee_id', 'employee_id');
    }
}
