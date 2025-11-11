<?php

namespace App\Modules\EmployeeManagement\Enums;

enum JobCategoryEnum: int
{
    case TECHNICAL = 1;
    case ADMINISTRATIVE = 2;
    case SUPPORT = 3;
    case MANAGEMENT = 4;

    public function label(): string
    {
        return match ($this) {
            self::TECHNICAL => 'Technical',
            self::ADMINISTRATIVE => 'Administrative',
            self::SUPPORT => 'Support',
            self::MANAGEMENT => 'Management',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}
