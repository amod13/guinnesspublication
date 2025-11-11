<?php

namespace App\Modules\EmployeeManagement\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
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
            'degree' =>'required','string',

            'institution_name' => 'required|string',

            'year_of_passing' => ['required', 'digits:4', 'integer', 'lte:' . now()->year],

            'grade_percentage' => [
                'required',
                function ($attribute, $value, $fail) {
                    $validGrades = ['A+', 'A', 'B+', 'B', 'C+', 'C', 'D', 'F', 'NG'];
                    $isNumeric = is_numeric($value);

                    if ($isNumeric) {
                        if ($value < 0 || $value > 100) {
                            $fail('The ' . $attribute . ' must be a percentage between 0 and 100.');
                        }
                    } elseif (!in_array(strtoupper(trim($value)), $validGrades)) {
                        $fail('The ' . $attribute . ' must be a valid grade (A+, A, B+, B, etc.) or a percentage between 0–100.');
                    }
                },
            ],

            'certificate' => 'required|file|mimes:pdf,jpeg,png,jpg',
        ];
    }
}
