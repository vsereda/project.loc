<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DishServingNotEmpty implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $result = false;
        foreach ($value as $ds) {
            $result = $result || is_numeric($ds);
        }
        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ошибка. Пустой заказ';
    }
}
