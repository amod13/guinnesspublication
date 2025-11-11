<?php

namespace App\Modules\EmployeeManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficialDocumentRequest extends FormRequest
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
            'resume_cv'          => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png'],
            'citizenship'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png'],
            'pan_card'           => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png'],
            'appointment_letter' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png'],
            'employee_contract'  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png'],
            'photo'              => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
        ];
    }
}
