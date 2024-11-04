<?php

namespace App\Enums;

enum UserRole: string
{
    // Define each role as a constant
    case ROLE_USER = 'user';
    case ROLE_COMPANY_ADMIN = 'company_admin';
    case ROLE_SUPER_ADMIN = 'super_admin';

    // Method to get all roles as an array of strings
    public static function getRoles(): array
    {
        return array_map(fn($role) => $role->value, self::cases());
    }
}
