<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleFormRequest extends FormRequest
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
            'client_id'=>'required',
            'carrier_id'=>'required',
            'type_voucher'=>'required|max:20',
            'serial_voucher'=>'max:7',
            'number_voucher'=>'required|max:10',
            'total'=>'required',
            //'idarticulo'=>'required',
            'status'=>'required',
            //'cantidad'=>'required',
            //'precio_compra'=>'required',
            //'precio_venta'=>'required'
        ];
    }
}