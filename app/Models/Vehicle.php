<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $primaryKey = 'vehicle_id';
    protected $fillable = ['plate_number', 'vehicle_type', 'owner_type', 'visit_id', 'attendance_id'];

    public function visit() { return $this->belongsTo(Visit::class, 'visit_id', 'visit_id'); }
    public function attendance() { return $this->belongsTo(Attendance::class, 'attendance_id', 'attendance_id'); }
}
