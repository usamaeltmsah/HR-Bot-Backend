<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = ['body', 'skill_id'];
    
    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('database.tables.questions'));
    }

    /**
     * The question may belong to one or more job
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_questions');
    }

    /**
     * The question may have one or more answer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * The question may have one or more model answer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modelAnswers(): HasMany
    {
        return $this->hasMany(ModelAnswer::class);
    }

    /**
     * The question may belong to one or more skill
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skill(): belongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    /**
     * Is this questions answered in the given interview
     * @param  Interview $interview
     * @return boolean
     */
    public function isAnsweredIn(Interview $interview)
    {
        return $this->answers()->where('interview_id', $interview->getKey())->exists();
    }
}
