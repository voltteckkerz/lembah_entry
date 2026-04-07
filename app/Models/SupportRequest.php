<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    protected $primaryKey = 'support_id';

    protected $fillable = [
        'username',
        'type',
        'status',
    ];
}
