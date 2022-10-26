<?php

namespace App\Enums;

enum BlogStatus: int
{
	case PUBLISHED = 1;
	case ARCHIVED = 2;
	case DELETED = 3;
}
