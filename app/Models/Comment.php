<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'body',
        'parent_id',
        'created_at',
        'image'

    ];

    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function branch()
    {
        return $this->belongsToMany(Branch::class,'branch_comments','comment_id','branch_id');
    }

    /**
     * @return bool
     */
    public function canBeModifies()
    {
        return Carbon::now()->subMinutes(60)->lt($this->created_at);
    }
}
