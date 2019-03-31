<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoHTMLTags implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !preg_match("#<[^>]*>#", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.no_html_tags');
    }
}
