<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Review;

class ReviewRequest extends FormRequest
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


    protected function prepareForValidation()
    {
        $this->merge([
            'demand_id' => $this->route('demand_id'),
            'user_id' => $this->route('user_id'),
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {

            case 'POST':

                return [
                    'demand_id' => 'required|integer|exists:demands,id',
                    'rating' => ['required', 'integer', Rule::in(Review::RATINGS)],
                    'comment' => 'required|string|max:2048',
                ];

            case 'GET':

                return [
                    'user_id' => 'required|integer|exists:users,id',
                ];
        }
    }

}
