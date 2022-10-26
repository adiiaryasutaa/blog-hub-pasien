<?php

namespace App\Enums;

enum UserRole: int
{
	case OWNER = 1;
	case ADMIN = 2;
	case NORMAL = 3;
}
