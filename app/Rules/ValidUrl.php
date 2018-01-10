<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidUrl implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $facebook = strpos($value, 'www.facebook.com') !== false and strpos($value, 'album_id') !== false;
        $siam2nite = strpos($value, 'www.siam2nite.com') !== false;
        $is_pass = (($facebook or $siam2nite)
                    and filter_var($value, FILTER_VALIDATE_URL));
        return $is_pass;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Url must be full url of Facebook public page\'s album or siam2nite\'s album';
    }
}
