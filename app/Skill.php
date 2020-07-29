<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    protected $fillable = ['name'];


    public function jobs(): BelongsToMany{
        return $this->belongsToMany(Job::class, 'skills_jobs');
    }

    public function questions(): BelongsToMany{
        return $this->belongsToMany(Question::class, 'skill_questions');
    }


}
