<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    protected $fillable = ['name'];

    /**
     * A skill may belongs to one or more jobs
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'skills_jobs');
    }

    /**
     * A skill may have one or more questions
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function questions(): HasMany
	{
		return $this->hasMany(Question::class);
	}
}
