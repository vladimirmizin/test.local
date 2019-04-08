<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'from_user',
        'title',
        'body'

    ];
    public function author()
    {
        return $this->belongsTo('App\User','from_user');
    }
}
