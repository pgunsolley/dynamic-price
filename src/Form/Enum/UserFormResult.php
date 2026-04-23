<?php
declare(strict_types=1);

namespace App\Form\Enum;

enum UserFormResult
{
    case Pending;
    case Success;
    case ValidationError;
    case UserNotFound;
    case InvalidPassword;
}
