<?php
namespace App\Enums;

enum RolesEnum: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case MEDIA = 'media'; 
    case ALUMNI = 'alumni';

    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => 'Админ',
            self::MANAGER => 'Менеджер',
            self::MEDIA => 'Медиа',
            self::ALUMNI => 'alumni',
        };
    }
}