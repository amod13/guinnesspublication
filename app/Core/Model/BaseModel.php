<?php

namespace App\Core\Model;

use App\Core\Traits\HasMediaLibrary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class BaseModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasMediaLibrary;

}
