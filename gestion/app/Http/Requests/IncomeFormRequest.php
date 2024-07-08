<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'provider_id'=>'required',
            'type_voucher'=>'required|max:20',
            'serial_voucher'=>'max:7',
            'number_voucher'=>'required|max:10',
            'item_id'=>'required',
            'status'=>'required',
            'quantity'=>'required',
            'sale_price'=>'required',
            'purchase_price'=>'required'
        ];
    }
}
