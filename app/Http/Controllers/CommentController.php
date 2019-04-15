<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Null_;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    protected function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3|string',
            'body' => 'required|min:1',
        ]);
        Comment::addComment($request);
        return back();
    }

    protected function addSubComment(Request $request)
    {
        $this->validate($request, [
            ('sub_body' . $request->get('parent_id'))  => 'required|min:1',
        ]);
        Comment::addSubComment($request);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    protected function edit($id)
    {
        /** @var Comment $comment */
        $comment = Comment::find($id);
        if ($comment->canBeModified()) {
            return view('edit')->with('comment', $comment);
        }
        return back()->withErrors('Cannot be modified');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    protected function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        if ($comment->canBeModified()) {
            $this->validate($request, [
                'title' => 'required|min:3|string',
                'body' => 'required|min:1'
            ]);
            if ($request->has('image')) {
                $path = $request->file('image')->store('uploads', 'public');
                $comment->image = $path;
            }
            $comment->title = $request->get('title');
            $comment->body = $request->get('body');
            $comment->save();
        }
        return redirect('home');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    protected function destroy($id)
    {
        $comment = Comment::find($id);
        if ($comment->canBeDeleted()) {
            $comment->delete();
        }
        return redirect('home');
    }
}
