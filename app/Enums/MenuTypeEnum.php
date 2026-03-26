<?php
namespace App\Enums;

enum MenuTypeEnum: int
{
    case PAGE = 0;
    case ALUMNI_PAGE = 1;
    case PRODUCT_PAGE = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::PAGE => 'Page',
            self::ALUMNI_PAGE => 'Alumni Page',
            self::PRODUCT_PAGE => 'Product Page',
        };
    }
}