<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $fillable = [
      'comment_id',
      'reaction',
    ];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

}
