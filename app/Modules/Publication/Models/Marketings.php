<?php

namespace App\Modules\Publication\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketings extends Model
{
    use HasFactory;

    protected $table = 'marketings';

    protected $fillable = [
        'user_id',
        'school_name',
        'school_address',
        'school_email',
        'school_phone',
        'visit_date',
        'remarks',
        'status',
        'display_order',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
