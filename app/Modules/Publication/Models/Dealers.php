<?php

namespace App\Modules\Publication\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealers extends Model
{
    use HasFactory;

    protected $table = 'dealers';

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'address',
        'pan_number',
        'contact_person',
        'status',
        'display_order',
    ];
}