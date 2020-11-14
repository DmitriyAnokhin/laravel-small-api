<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
                    'title' => 'required|string|max:255',
                    'description' => 'required|string|max:255',
                    'execution_date' => 'required|date',
                    'percentage_intermediary' => 'required|integer|min:1|max:100',
                ];

            case 'PUT':
            case 'GET':

                return [
                    'id' => 'required|integer|exists:orders,id',
                ];
        }
    }

}
