<?php

namespace App\Modules\EmployeeManagement\Enums;

enum EmploymentTypeEnum: int
{
    case FULL_TIME = 1;
    case PART_TIME = 2;
    case CONTRACT = 3;
    case INTERN = 4;

    public function label(): string
    {
        return match ($this) {
            self::FULL_TIME => 'Full-time',
            self::PART_TIME => 'Part-time',
            self::CONTRACT => 'Contract',
            self::INTERN => 'Intern',
        };
    }
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}
