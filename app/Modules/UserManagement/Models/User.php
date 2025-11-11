<?php

namespace App\Modules\UserManagement\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Modules\UserManagement\Models\Role;
use App\Core\Traits\HasMediaLibrary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method string|null getMediaUrl(string $fieldName)
 * @method \App\Modules\MediaLibarary\Models\MediaLibrary|null getMedia(string $fieldName)
 * @method $this setMedia(string $fieldName, int $mediaId)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasMediaLibrary;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'email_verification_token',
        'is_superadmin',
        'status',
        'last_login',
        'display_order',
        'profile_image',
        'profile_image_id',
        'full_name',
        'employee_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

}
