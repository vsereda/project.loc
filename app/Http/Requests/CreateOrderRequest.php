<?php

namespace App\Http\Requests;

use App\Rules\DishServingNotEmpty;
use App\Rules\DishServingRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user() && Auth::user()->hasRole('user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'dinner_time' => [
//                'required',
//                Rule::in([1, 2, 3]),
//            ],
            'dish_servings' => [
                new DishServingRule,
                new DishServingNotEmpty(),
            ],
        ];
    }
}
