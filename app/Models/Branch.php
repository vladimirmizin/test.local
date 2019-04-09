<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    public function comment()
    {
        return $this->belongsToMany(Branch::class,'branch_comments','branch_id','comment_id');
    }
}
