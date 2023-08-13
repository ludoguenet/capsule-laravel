<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'Super Admin';
    case TEACHER = 'teacher';
    case STUDENT = 'student';
}
