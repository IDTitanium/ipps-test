<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the lessons watched by the user
     *
     * @return BelongsToMany
     */
    public function watched(): BelongsToMany {
        return $this->belongsToMany(Lesson::class, 'lesson_user', 'user_id', 'lesson_id');
    }

    /**
     * Get the comments written by the user
     *
     * @return HasMany
     */
    public function comments(): HasMany {
        return $this->hasMany(Comment::class, 'user_id');
    }

    /**
     * Get total count of comments written by the user
     *
     * @return int
     */
    public function getTotalCommentsAttribute(): int {
        return $this->comments()->count();
    }

    /**
     * Get total count of lessons watched by the user
     *
     * @return int
     */
    public function getTotalWatchedAttribute(): int {
        return $this->watched()->count();
    }
}
