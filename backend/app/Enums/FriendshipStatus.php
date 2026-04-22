<?php

namespace App\Enums;

enum FriendshipStatus: string
{
    case PENDING = 'PENDING';
    case ACCEPTED = 'ACCEPTED';
    case BLOCKED = 'BLOCKED';
}
