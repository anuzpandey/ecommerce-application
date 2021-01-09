<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductFormRequest extends FormRequest
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
            'name' => 'required|max:255',
            'sku' => 'required',
            'brand_id' => 'required|not_in:0',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/', // checking if the value passed to this field is decimal or not.
            'sale_price' => 'required|regex:/^\d+(\.\d{1,2})?$/', // checking if the value passed to this field is decimal or not.
            'quantity' => 'required|numeric',
            'weight' => 'numeric'
        ];
    }
}
