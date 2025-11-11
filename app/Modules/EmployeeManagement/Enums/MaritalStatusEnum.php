<?php

namespace App\Modules\EmployeeManagement\Enums;

enum MaritalStatusEnum: int
{
    case SINGLE = 1;
    case MARRIED = 2;
    case DIVORCED = 3;
    case WIDOWED = 4;

    public function label(): string
    {
        return match ($this) {
            self::SINGLE => 'Single',
            self::MARRIED => 'Married',
            self::DIVORCED => 'Divorced',
            self::WIDOWED => 'Widowed',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}
