<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Is this user a recruiter
     * 
     * @return boolean
     */
    public function isRecruiter(): bool {
        return 'recruiter' == $this->role;
    }

    /**
     * Is this user a applicant
     * 
     * @return boolean
     */
    public function isApplicant(): bool {
        return 'applicant' == $this->role;
    }
}
