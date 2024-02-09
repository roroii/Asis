<?php

namespace App\Rules;

use App\Models\ASIS_Models\pre_enrollees\pre_enrollees;
use Illuminate\Contracts\Validation\Rule;

class RegistrationRule implements Rule
{
    protected $table;
    protected $column;

    public function __construct($table, $column)
    {
        $this->table = $table;
        $this->column = $column;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */

    public function passes($attribute, $value)
    {
        return !pre_enrollees::where($this->column, $value)->where('email', null)->exists();
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
