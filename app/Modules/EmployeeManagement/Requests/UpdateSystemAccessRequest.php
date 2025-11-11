<?php

namespace App\Modules\EmployeeManagement\Requests;

use App\Modules\EmployeeManagement\Enums\StatusEnum;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateSystemAccessRequest extends FormRequest
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
        $employeeId = $this->route('employeeId');

        return [
            'username' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z_][a-zA-Z0-9_]*$/',
                Rule::unique('users', 'name')->ignore($employeeId, 'employee_id'),
            ],
            'password' => 'nullable|string|min:6|max:255',
            'confirm_password' => 'nullable|string|same:password',
            'status' => ['required', new Enum(StatusEnum::class)],
            'role_id' => 'required|exists:roles,id',
        ];
    }

    public function messages(): array
    {
        return [
            'username.regex' => 'Username must start with a letter or underscore, and contain only letters, numbers, or underscores (no spaces).',
            'username.unique' => 'This username is already taken.',
        ];
    }
}
