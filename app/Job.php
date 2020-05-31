<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Job extends Model
{
    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('database.tables.jobs'));
    }

    /**
     * The job may need answers for one or more question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }

    /**
     * A job may have one or more done interviews
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class);
    }
}
