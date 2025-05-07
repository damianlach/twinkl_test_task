<?php

declare(strict_types=1);

namespace App\Enum;

enum RoleType: string
{
    case STUDENT = 'student';
    case TEACHER = 'teacher';
    case PARENT = 'parent';
    case TUTOR = 'tutor';
}