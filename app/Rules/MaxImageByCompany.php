<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxImageByCompany implements Rule
{
    private $maxImages = 20;
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $guid = \App\GUID::find($value);
        if (!$guid) return true;
        $imagesTotal = $guid->images()->count();
        if ($imagesTotal < $this->maxImages) return true;
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('image.max_images', ['numImages' => $this->maxImages]);
    }
}
