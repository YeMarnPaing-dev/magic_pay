<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferValidate extends FormRequest
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
            'to_phone'=>'required',
            'amount'=>'required|min:4',

        ];
    }

    public function messages(){
        return [
            'to_phone.required' => 'The phone number field is required',
            'amount.min'=> 'The amount must be at least 1000 Kyats',

        ];
    }
}
