<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
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
            'name'  => 'required|min:5',
            'email' => 'required|email|string|lowercase',
            'telephone' => 'required|max:15|min:9',
            'address'   => 'required|string|max:50|min:5',
            'training_slot' => 'required|exists:training_slots,id'
        ];
    }
}
