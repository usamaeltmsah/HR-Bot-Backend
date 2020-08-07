<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Interview extends Model
{
    protected $fillable = [
        'job_id', 
        'applicant_id'
    ];

    /**
     * The attributes that should be casted.
     *
     * @var array
     */
    protected $casts = [
        'submitted_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('database.tables.interviews'));
    }

    /**
     * The interview is done for a specific job
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * The interview may have one or more answer
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * The interview may have one or more questions
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions(): BelongsToMany
    {
        return $this->job->questions();
    }

    /**
     * check wether this interview is in progress
     * 
     * @return boolean
     */
    public function isInProgress(): bool
    {
        return ! $this->isSubmitted() && $this->hasTimeToSubmit();
    }

    /**
     * Check wheter this interview has time to submit
     * 
     * @return boolean
     */
    public function hasTimeToSubmit(): bool
    {
        return now()->diffInSeconds($this->created_at) < $this->job->interview_duration;
    }

    /**
     * Is this interview submitted
     * 
     * @return boolean
     */
    public function isSubmitted(): bool
    {
        return !is_null($this->submitted_at);
    }
}
