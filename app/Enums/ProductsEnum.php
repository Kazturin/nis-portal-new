<?php
namespace App\Enums;

enum ProductsEnum: string
{
    case KIVA = 'kiva';
    case LIBRARY = 'library';

    public function getTemplate(): string
    {
        return match ($this) {
            self::KIVA => 'kiva',
            self::LIBRARY => 'library',
        };
    }
}