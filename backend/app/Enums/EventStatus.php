<?php

namespace App\Enums;

enum EventStatus: string
{
    case OPEN = 'OPEN';
    case FULL = 'FULL';
    case CLOSED = 'CLOSED';
}
