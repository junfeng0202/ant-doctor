<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackImage extends Model
{
    public $timestamps = false;

    public $fillable = ['feedback_id', 'image'];
}
