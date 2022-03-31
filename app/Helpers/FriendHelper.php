<?php

namespace App\Helpers;

use App\Services\FriendService;

class FriendHelper extends BasicHelper
{
    const STATUS_NOT_FRIENDS = 0;
    const STATUS_IN_SUBSCRIBERS = 1;
    const STATUS_REQUEST_SENT = 2;
    const STATUS_FRIENDS = 3;
}
