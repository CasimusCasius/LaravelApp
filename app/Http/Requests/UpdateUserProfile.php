<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpaces;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = Auth::id();
        return [
            'email' =>
            [
                'required',
                //'unique:users',
                Rule::unique('users')->ignore($userId),
                'email'
            ],
            'name' =>
            [
                'required',
                'max:50',
                new AlphaSpaces(),
            ],
            'phone' => 'max:15'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Podany e-mail jest już zajęty',
            'email.email' => 'Podany ciąg znaków nie jest adresem e-mail',
            'email.required' => 'Pole e-mail jest wymagane',
            'name.required' => 'Pole Nazwa jest wymagane',
            'name.max' => 'Ciąg znaków nie może być dluższy niż :max znaków'
        ];
    }
}
