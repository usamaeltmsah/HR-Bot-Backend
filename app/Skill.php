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

    /** it should work when make a relation between skills and questions */
//    public function questions(): BelongsToMany{
//        return $this->belongsToMany(Question::class, 'skills_questions');
//    }


}
