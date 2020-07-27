<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Recruiter extends User
{
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
