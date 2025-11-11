<?php

namespace App\Modules\Publication\Enums;

enum ProvinceEnum: string
{
    case KOSHI = 'koshi';
    case MADHESH = 'madhesh';
    case BAGMATI = 'bagmati';
    case GANDAKI = 'gandaki';
    case LUMBINI = 'lumbini';
    case KARNALI = 'karnali';
    case SUDURPASCHIM = 'sudurpaschim';

    public function label(): string
    {
        return match($this) {
            self::KOSHI => 'Koshi Province',
            self::MADHESH => 'Madhesh Province',
            self::BAGMATI => 'Bagmati Province',
            self::GANDAKI => 'Gandaki Province',
            self::LUMBINI => 'Lumbini Province',
            self::KARNALI => 'Karnali Province',
            self::SUDURPASCHIM => 'Sudurpaschim Province',
        };
    }

    public static function options(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => $case->label()
        ], self::cases());
    }
}
