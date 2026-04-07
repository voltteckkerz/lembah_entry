<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $primaryKey = 'attendance_id';

    protected $fillable = ['employee_id', 'vehicle_plate', 'check_in_time', 'check_out_time', 'user_id'];

    protected $casts = [
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
