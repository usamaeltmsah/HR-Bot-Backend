<?php

namespace App;

use App\Scopes\ApplicantScope;

class Applicant extends User
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ApplicantScope);
    }
}
