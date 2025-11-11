<?php
namespace App\Modules\Publication\Enums;

class MenuTypeEnum
{
    public  const Primary = 1;
    public  const Secondary = 2;
    public  const Footer = 3;

    public static function getMenuTypeName($menuTypeId)
    {
        switch ($menuTypeId) {
            case self::Primary:
                return 'Primary Menu';
            case self::Secondary :
                return 'Secondary Menu';
            case self::Footer :
                return 'Footer Menu';
            default:
                return null;
        }
    }
    public static function getMenuTypes()
    {
        $menuTypes = collect();
        foreach ([
            self::Primary, self::Secondary, self::Footer,
        ] as $menuTypeId) {
            $menuTypes->push(['id' => $menuTypeId, 'name' => self::getMenuTypeName($menuTypeId)]);
        }
        return $menuTypes;
    }
}
