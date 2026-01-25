<?php

namespace App\Enums;

enum IdempotencyStatusEnum: string{
    case IN_PROGRESS = 'in_progress';
    case COMPLETE = 'complete';
    case FAILED = 'failed';
}