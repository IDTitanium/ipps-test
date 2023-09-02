<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementUser extends Model
{
    use HasFactory;

    /**
     * The related table name
     *
     * @var string
     */
    protected $table = 'achievement_user';
}
