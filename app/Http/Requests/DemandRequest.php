<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DemandRequest extends FormRequest
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
            'id' => $this->route('id'),
            'order_id' => $this->route('order_id'),
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
            case 'GET':

                return [
                    'order_id' => 'required|integer|exists:orders,id',
                ];

            case 'PUT':

                return [
                    'id' => 'required|integer|exists:demands,id',
                    'order_id' => 'required|integer|exists:orders,id',
                ];

        }
    }

}
