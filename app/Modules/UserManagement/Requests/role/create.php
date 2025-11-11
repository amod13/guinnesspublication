<?php

namespace App\Modules\UserManagement\Requests\role;

use App\Core\Request\BaseFormRequest;
use Illuminate\Validation\Rule;
use App\Modules\UserManagement\Models\Role;

class create extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function getCreateRules(): array
    {
        return [
            'name' => 'required|unique:roles,name',
            'is_superadmin' => [
                'nullable',
                'in:0,1',
                function ($attribute, $value, $fail) {
                    if ($value == 1) {
                        $exists = Role::where('is_superadmin', 1)->exists();
                        if ($exists) {
                            $fail('There can be only one superadmin role.');
                        }
                    }
                },
            ],
        ];
    }

    protected function getUpdateRules(): array
    {
        $roleId = $this->getRouteId();

        return [
            'name' => [
                'required',
                Rule::unique('roles', 'name')->ignore($roleId),
            ],
            'is_superadmin' => [
                'nullable',
                'in:0,1',
                function ($attribute, $value, $fail) use ($roleId) {
                    if ($value == 1) {
                        $exists = Role::where('is_superadmin', 1)
                            ->where('id', '!=', $roleId)
                            ->exists();
                        if ($exists) {
                            $fail('There can be only one superadmin role.');
                        }
                    }
                },
            ],
        ];
    }
}
