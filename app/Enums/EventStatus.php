<?php

namespace App\Enums;

enum EventStatus: string
{
    case INITIATE = 'initiate';
    case PRE_EVENT = 'pre-event';
    case EVENT = 'event';
    case POST_EVENT = 'post-event';
    case END = 'end';
    case POSTPONE = 'postpone';
    case CANCEL = 'cancel';
}
