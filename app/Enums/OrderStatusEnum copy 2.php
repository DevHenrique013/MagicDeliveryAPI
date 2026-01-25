<?php

namespace App\Enums;

enum OrderStatusEnum: string{
    case PENDING = 'pending';
    case PAID = 'paid';
    case FAILED = 'failed';
    case CANCELED = 'canceled';
}