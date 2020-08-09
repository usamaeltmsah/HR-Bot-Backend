<?php

namespace App;

use App\Scopes\AdminScope;

class Admin extends User
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new AdminScope);
    }
}
