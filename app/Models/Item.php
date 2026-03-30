<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $primaryKey = 'item_id';
    protected $fillable = ['visit_id', 'item_name', 'quantity', 'remarks'];

    public function visit() { return $this->belongsTo(Visit::class, 'visit_id', 'visit_id'); }
}
