<?php

namespace App;

use App\Scopes\RecruiterScope;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recruiter extends User
{	
	/**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new RecruiterScope);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'recruiter_id', 'id');
    }
}
