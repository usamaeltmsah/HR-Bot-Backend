<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recruiter extends Model
{
    protected $fillable = [];

    protected $hidden = [];

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
