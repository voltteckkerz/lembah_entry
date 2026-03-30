<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $primaryKey = 'notification_id';
    protected $fillable = ['user_id', 'visit_id', 'message', 'status'];

    public function user() { return $this->belongsTo(User::class, 'user_id', 'user_id'); }
    public function visit() { return $this->belongsTo(Visit::class, 'visit_id', 'visit_id'); }
}
