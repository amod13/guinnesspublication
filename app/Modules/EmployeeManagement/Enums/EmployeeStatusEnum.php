<?php

namespace App\Modules\EmployeeManagement\Enums;

enum EmployeeStatusEnum: int
{
    case ACTIVE = 1;
    case INACTIVE = 2;
    case ON_LEAVE = 3;
    case TERMINATED = 4;

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::ON_LEAVE => 'On Leave',
            self::TERMINATED => 'Terminated',
        };
    }
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}
