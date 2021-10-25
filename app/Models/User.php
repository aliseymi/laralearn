<?php

namespace App\Models;

use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'two_factor_type',
        'phone_number',
        'is_superuser',
        'is_staff',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function activeCodes()
    {
        return $this->hasMany(ActiveCode::class);
    }

    public function hasTwoFactor($key)
    {
        return $this->two_factor_type == $key;
    }

    public function hasTwoFactorAuthenticationEnabled()
    {
        return $this->two_factor_type !== 'off';
    }

    public function hasSmsTwoFactorAuthenticationEnabled()
    {
        return $this->two_factor_type == 'sms';
    }

    public function isSuperUser()
    {
        return $this->is_superuser;
    }

    public function isStaff()
    {
        return $this->is_staff;
    }

    public function hasRole($role)
    {
        return !! $role->intersect($this->roles)->all();
    }

    public function hasPermission($permission)
    {
        return $this->permissions->contains('name',$permission->name) || $this->hasRole($permission->roles);
    }
}
