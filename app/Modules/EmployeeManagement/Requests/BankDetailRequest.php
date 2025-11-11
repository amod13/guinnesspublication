<?php

namespace App\Modules\EmployeeManagement\Requests;

use App\Modules\EmployeeManagement\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class BankDetailRequest extends FormRequest
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
            'basic_salary' => ['required', 'numeric', 'min:0'],
            'allowances' => ['required', 'numeric', 'min:0'],
            'deductions' => ['required', 'numeric', 'min:0'],
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_account_number' => ['required', 'string', 'max:255', Rule::unique('emp_salary_details', 'bank_account_number')],
            'provident_fund_no' => ['required', 'string', 'max:255', Rule::unique('emp_salary_details', 'provident_fund_no')],
            'status' => ['required', new Enum(StatusEnum::class)],
        ];
    }
}
