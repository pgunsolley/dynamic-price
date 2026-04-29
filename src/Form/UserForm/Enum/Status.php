<?php
declare(strict_types=1);

namespace App\Form\UserForm\Enum;

enum Status
{
    case Pending;
    case Success;
    case ValidationError;
    case UserNotFound;
    case InvalidPassword;
}
