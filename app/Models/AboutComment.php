<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutComment extends Model
{
    protected $fillable = [
        'id',
        'sub_comment_id',
        'parent_comment_id',
        'flag'
    ];
    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    public function subComment()
    {
        return $this->belongsTo(Comment::class, 'sub_comment_id');
    }

    public function parentAuthor()
    {
        return $this->hasManyThrough(User::class, Comment::class, 'user_id', 'id');
    }

    public function subAuthor()
    {
        return $this->hasManyThrough(User::class, Comment::class, 'user_id', 'id');
    }
}
