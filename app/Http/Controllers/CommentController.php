<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function store(Request $request, Comment $comment)
    {
        $this->validate($request, [
            'body' => 'required',
            'title' => 'required'
        ]);
        $newComment = $request->user()->comments()->create([
            'body' => $request->get('body'),
            'title' => $request->get('title')
        ]);
        return response()->json($comment->with('user')->find($newComment->id));
    }

    public function addSubComment(Request $request)
    {

        $newComment = $request->user()->comments()->create([
            'body' => $request->get('body'),
            'title' => $request->get('title'),
            'parent_id' => $request->get('parent_id')
        ]);
        return response()->json($newComment->with('user')->find($newComment->id));
    }

    public function index()
    {
        $comments = Comment::with('user', 'sub_comments.user')
            ->whereNull('parent_id')
            ->get()
            ->map(function (Comment &$comment) {
                $comment->can_be_modified = $comment->canBeModified($comment->user->id);
                $comment->can_be_deleted = $comment->canBeDeleted($comment->user->id);
                return $comment;
            });

        return $comments;
    }


    public function update($id, Request $request)
    {
        $comment = Comment::find($id);
        $comment->title = $request->get('val_1');
        $comment->body = $request->get('val_2');
        $comment->save();
        return $comment;
    }

    public function delete($request)
    {
        $comment = Comment::find($request);
        if ($comment->canBeDeleted()) {
            $comment->delete();
            return Comment::with('user')->whereNull('parent_id')->get();
        }
        return 'Fatal Error';
    }
}
