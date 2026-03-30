<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $primaryKey = 'staff_id';
    protected $fillable = ['name', 'department'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'staff_id', 'staff_id');
    }
}
