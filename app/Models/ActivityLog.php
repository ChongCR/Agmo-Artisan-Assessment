<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $log_name
 * @property string $causer_ip_address
 */
class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_log';
}
