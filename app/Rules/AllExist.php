<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AllExist implements Rule
{
    /**
     * The model that we should check over it
     * 
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Custom column to check over
     * 
     * @var string
     */
    protected $column;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $modelName, ?string $customColumn = null)
    {
        $this->model = app($modelName);
        $this->column = $customColumn ?: $this->model->getKeyName();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  array  $values
     * @return bool
     */
    public function passes($attribute, $values)
    {
        $unique_values = array_unique($values);
        return $this->model->whereIn($this->column, $unique_values)->count() === count($unique_values);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'All :attribute must exist in our database.';
    }
}
