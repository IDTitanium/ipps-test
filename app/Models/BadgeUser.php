<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadgeUser extends Model
{
    use HasFactory;

    /**
     * The related table name
     *
     * @var string
     */
    protected $table = 'badge_user';
}
