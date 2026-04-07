<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $primaryKey = 'visit_id';

    protected $fillable = [
        'employee_id',
        'user_id',
        'pass_number',
        'visit_date',
        'check_in_time',
        'check_out_time',
        'purpose',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function visitors()
    {
        return $this->belongsToMany(Visitor::class, 'visit_visitor', 'visit_id', 'visitor_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'visit_id', 'visit_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'visit_id', 'visit_id');
    }
}
