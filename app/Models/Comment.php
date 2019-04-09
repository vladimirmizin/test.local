<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'parent_id',
        'created_at'

    ];

    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function branch()
    {
        return $this->belongsToMany(Branch::class,'branch_comments','comment_id','branch_id');
    }

}
