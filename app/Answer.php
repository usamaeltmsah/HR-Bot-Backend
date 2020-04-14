<?php

namespace App;

use App\Events\AnswerCreated;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    protected $fillable = ['score', 'body', 'question_id'];

    /**
     * The event map for the model
     * @var array $dispatchesEvents
    */
    protected $dispatchesEvents = [
        'created' => AnswerCreated::class,
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('database.tables.answers'));
    }

    /**
     * The answer should be an answer for some question
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * The answer should be an answer for some question
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function interview(): BelongsTo
    {
        return $this->belongsTo(interview::class);
    }
}