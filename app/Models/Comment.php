<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Comment extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'body',
        'parent_id',
        'created_at',
        'image',
        'url'

    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branch()
    {
        return $this->belongsToMany(Branch::class, 'branch_comments', 'comment_id', 'branch_id');
    }

    /**
     * @return bool
     */
    public function canBeModified()
    {
        if (($this->user_id === auth()->user()->id) && (Carbon::now()->subMinutes(60)->lt($this->created_at))) {
            return true;
        }
    }

    public function canBeDeleted()
    {
        if ($this->user_id === auth()->user()->id) {
            return true;
        }
    }

    public function sub_comments()
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->orderByDesc('created_at');
    }

    public static function addComment($request)
    {
        if ($request->file('image') != null) {
            $path = $request->file('image')->store('uploads', 'public');
            $input['image'] = $path;
        }
        $input['user_id'] = $request->user()->id;
        $input['parent_id'] = $request->get('parent_id');
        $input['body'] = $request->get('body');
        $input['title'] = $request->get('title');
        self::create($input);

    }

    public static function addSubComment($request)
    {
        if ($request->file('image') != null) {
            $path = $request->file('image')->store('uploads', 'public');
            $input['image'] = $path;
        }
        $input['user_id'] = $request->user()->id;
        $input['parent_id'] = $request->get('parent_id');
        $input['body'] = $request->get('sub_body' . $request->get('parent_id'));
        $input['title'] = $request->get('title');
        self::create($input);

    }

    public function hasImage()
    {
        return !is_null($this->image);
    }

    public function getStoragePath()
    {
        if ($this->hasImage()) {
            return Storage::url($this->image);
        } else {
          return null;
        }
    }


}
