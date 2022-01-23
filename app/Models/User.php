<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;




class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'trial_until',
      
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

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function getFreeTrialDaysLeftAttribute()
    {
        // if($this->plan_until)
        // {
        //     return 0;
        // }
       // return now()->diffInDays($this->trial_until,false);
        return $this->attributes['admin'] = now()->diffInDays($this->trial_until,false);
    }

    protected $dates=[
        'trial_until'
    ];

    protected $appends = ['free_trial_days_left'];
}
