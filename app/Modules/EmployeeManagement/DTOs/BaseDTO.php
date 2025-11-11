<?php

namespace App\Modules\EmployeeManagement\DTOs;

abstract class BaseDTO
{
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists(static::class, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function fromData(array|object $data): static
    {
        $array = is_array($data) ? $data : $data->toArray();
        return new static($array);
    }

    public static function fromCollection($items)
    {
        if (method_exists($items, 'getCollection')) {
            $items->getCollection()->transform(fn($item) => static::fromData($item));
            return $items;
        }

        return collect($items)->map(fn($item) => static::fromData($item));
    }

    // public static function getIdAndName(array|object $items)
    // {
    //     return collect($items)->map(function ($item) {
    //         $array = is_array($item) ? $item : $item->toArray();
    //         return [
    //             'id' => $array['id'] ?? null,
    //             'name' => $array['name'] ?? null,
    //         ];
    //     });
    // }
    public static function getIdAndName(array|object $items)
    {
        return collect($items)->map(function ($item) {
            if (is_array($item)) {
                $array = $item;
            } elseif ($item instanceof \Illuminate\Database\Eloquent\Model) {
                // Eloquent model: has toArray()
                $array = $item->toArray();
            } elseif (is_object($item)) {
                // stdClass or other object without toArray()
                $array = (array) $item;  // cast object to array
            } else {
                // fallback, in case of unexpected type
                $array = [];
            }

            return [
                'id' => $array['id'] ?? null,
                'name' => $array['name'] ?? null,
            ];
        });
    }


    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
