<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $primaryKey = 'visitor_id';
    protected $fillable = ['name', 'ic_number', 'phone', 'company'];

    public function visits()
    {
        return $this->belongsToMany(Visit::class, 'visit_visitor', 'visitor_id', 'visit_id');
    }
}
