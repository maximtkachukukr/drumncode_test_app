<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Task statuses
 */
enum TaskStatus: string
{
    case TODO = 'todo';
    case DONE = 'done';
}
