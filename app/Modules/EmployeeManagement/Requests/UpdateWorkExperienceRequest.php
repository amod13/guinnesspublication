<?php

namespace App\Modules\EmployeeManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkExperienceRequest extends FormRequest
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
            'organization_name'      => 'required|string|max:255',
            'designation'            => 'required|string|max:255',
            'from_date'              => ['required', 'date', 'before_or_equal:today'],
            'to_date'                => ['required', 'date', 'after_or_equal:from_date', 'before_or_equal:today'],
            'reason_for_leaving'     => 'required|string|max:500',
            'experience_letter'      => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ];
    }
}
