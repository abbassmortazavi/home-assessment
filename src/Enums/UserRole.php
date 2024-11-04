<?php

namespace App\Enums;

enum UserRole: string
{
    // Define each role as a constant
    case ROLE_USER = 'ROLE_USER';
    case ROLE_COMPANY_ADMIN = 'ROLE_COMPANY_ADMIN';
    case ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    // Method to get all roles as an array of strings
    public static function getRoles(): array
    {
        return array_map(fn($role) => $role->value, self::cases());
    }
}
