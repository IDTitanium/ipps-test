<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    /**
     * Disable model timestamps
     */
    public $timestamps = false;

    /**
     * The fillable properties of the model
     *
     * @var array
     */
    protected $fillable = ['name', 'count_required', 'type'];
}
