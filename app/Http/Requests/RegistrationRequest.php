<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class RegistrationRequest extends FormRequest
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
        return [
            'email' => 'required|email:rfc,dns|max:100',
            'password' => 'required|string|between:8,30',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'type' => ['required', 'string', Rule::in(User::TYPES)],
        ];
    }
}
