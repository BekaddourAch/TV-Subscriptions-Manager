<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'mobile',
        'status',
        'password',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'profile_url',
    ];

    public function status(): string
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function getProfileUrlAttribute()
    {
        if ($this->profile_photo_path && Storage::disk('profile_photos')->exists($this->profile_photo_path)) {
            return Storage::disk('profile_photos')->url($this->profile_photo_path);
        }
        //return asset('noimage.png');
    }

    public function hasPermission($permissions)
        {if($this->hasRole('superadmin')){
            return true;
        }
        foreach ($this->roles as $role) {
            if(is_array($permissions)){
                foreach ($permissions as $permission) {
                    if ($role->permissions->contains('name', $permission)) {
                        return true;
                    }   
                }
            }
            else{
                if ($role->permissions->contains('name', $permissions)) {
                    return true;
                } 
            }
            
        }

        return false;
    }
}
