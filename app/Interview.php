<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

        // Make sure sumitted at is not null and make it the maximum submit time
        self::creating(function (Interview $interview) {
            if(is_null($interview->submitted_at)) {
                $duration = $interview->job->interview_duration;

                $interview->submitted_at = now()->addSeconds($duration);     
            }
        });
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
     * The interview is done by a specific applicant
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class, 'applicant_id', 'id');
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
     * check whether this interview is in progress
     * 
     * @return boolean
     */
    public function isInProgress(): bool
    {
        return ! $this->isSubmitted();
    }

    /**
     * check whether the given user is the applicant of this interview
     * 
     * @return boolean
     */
    public function isTheApplicant(User $user): bool
    {
        return $this->applicant_id == $user->getKey();
    }

    /**
     * Check whether this interview should ask this question
     * @param  Question $question 
     * @return boolean
     */
    public function hasQuestion(Question $question): bool
    {
        return $this->questions->contains($question);
    }
    
    /**
     * Is this interview submitted
     * 
     * @return boolean
     */
    public function isSubmitted(): bool
    {
        return $this->submitted_at->isPast();
    }

    /**
     * Check wether this interview is for the given job
     * 
     * @param  \App\Job    $job
     * 
     * @return boolean
     */
    public function isForJob(Job $job): bool
    {
        return $job->getKey() == $this->job_id;
    }

    /**
     * Submit this interview
     * 
     * @return void
     */
    public function submit(): void
    {
        $this->submitted_at = now();
        $this->save();
    }

    /**
     * only interviews that the given user is the applicant of it
     * 
     * @param  \Illuminate\Database\Eloquent\Builder    $query
     * @param  \App\User                                $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereIsTheApplicant(Builder $query, User $user): Builder
    {
        return $query->where('applicant_id', $user->getKey());
    }

    /**
     * Get status attribute
     * 
     * @param  string|null $status
     * @return string
     */
    public function getStatusAttribute(?string $status): string
    {
        if (is_null($status)) {
            return $this->isSubmitted() ? 'submitted' : 'interviewing';
        }

        return $status;
    }

    /**
     * Get this interview duration
     * 
     * @return int
     */
    public function getRemainingTimeAttribute()
    {        
        $remaining_time = now()->diffInSeconds($this->submitted_at);
        
        if ($remaining_time <= 0) {
            return 0;
        }

        return $remaining_time;
    }

    public function recalculateScore()
    {
        $this->score = $this->answers()->sum('score');
        $this->save();
    }

    public function getSkillsNamesNeedImprovement()
    {
        $questions = $this->questions()->with(['answers' => function($query) {
                            $query->where('interview_id', $this->getKey());
                        }])->get();

        $skills_statistics = [];
        foreach ($questions as $question) {
            if (!isset($skills_statistics[$question->skill_id])) {
                $skills_statistics[$question->skill_id] = [
                    'total' => 0,
                    'counter' => 0,
                ];
            }

            $skills_statistics[$question->skill_id]['counter'] += 1;
            if ($question->answers->isNotEmpty()) {
                $skills_statistics[$question->skill_id]['total'] += $question->answers->first()->score;
            }
        }

        $skills_ids = [];
        foreach ($skills_statistics as $skill => $statisitcs) {
            if (($statisitcs["total"] / $statisitcs["counter"]) < 5) {
                $skills_ids[] = $skill;
            }
        }

        $res = Skill::whereIn('id', $skills_ids)->pluck('name')->toArray();

        return $res;
    }

    public function getFeedbackAttribute(string $feedback): array
    {
        return json_decode($feedback, true);
    }
}
