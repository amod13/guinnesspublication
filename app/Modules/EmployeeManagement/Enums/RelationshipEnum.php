<?php

namespace App\Modules\EmployeeManagement\Enums;

enum RelationshipEnum: int
{
    case FATHER = 1;
    case MOTHER = 2;
    case SPOUSE = 3;
    case GUARDIAN = 4;
    case RELATIVE = 5;
    case COLLEAGUE = 6;
    case OTHER = 7;

    public function label(): string
    {
        return match ($this) {
            self::FATHER => 'Father',
            self::MOTHER => 'Mother',
            self::SPOUSE => 'Spouse',
            self::GUARDIAN => 'Guardian',
            self::RELATIVE => 'Relative',
            self::COLLEAGUE => 'Colleague',
            self::OTHER => 'Other',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}
