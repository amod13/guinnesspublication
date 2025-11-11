<?php

namespace App\Modules\Publication\Enums;

enum HighlightTypeEnum: string
{
    case Normal = 'normal';
    case Popular = 'popular';
    case BestSelling = 'best_selling';
    case FlashSale = 'flash_sale';
    case Featured = 'featured';
    case NewArrival = 'new_arrival';

    public function label(): string
    {
        return match($this) {
            self::Normal => 'Normal',
            self::Popular => 'Popular',
            self::BestSelling => 'Best Selling',
            self::FlashSale => 'Flash Sale',
            self::Featured => 'Featured',
            self::NewArrival => 'New Arrival',
        };
    }

    public static function list(): array
    {
        return array_map(fn($status) => [
            'id' => $status->value,
            'name' => $status->label(),
        ], self::cases());
    }
}
