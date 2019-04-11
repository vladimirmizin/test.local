<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        if ($request->file('image') != null) {
            $path = $request->file('image')->store('uploads', 'public');
            $input['image'] = $path;
        }
        $input['user_id'] = $request->user()->id;
        $input['title'] = $request->get('title');
        $input['body'] = $request->get('body');
        Comment::create($input);
        return back();
    }

    protected function addSubComment(Request $request, $parent_id, $title)
    {
        $this->validate($request, [
            'sub_body' => 'required|min:1',
        ]);
        if ($request->file('image') != null) {
            $path = $request->file('image')->store('uploads', 'public');
            $input['image'] = $path;
        }
        $input['user_id'] = $request->user()->id;
        $input['title'] = $title;
        $input['body'] = $request->get('sub_body');
        $input['parent_id'] = $parent_id;
        Comment::create($input);
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
        if (($comment->canBeModifies()) && ($comment->user_id == auth()->user()->id)) {
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
        if (($comment->canBeModifies()) && ($comment->user_id == auth()->user()->id)) {
            $this->validate($request, [
                'title' => 'required|min:3|string',
                'body' => 'required|min:1'
            ]);
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
    protected function destroy(Request $request, $id)
    {
        $comment = Comment::find($id);
        if ($comment && ($comment->user_id == $request->user()->id)) {
            $comment->delete();
        }
        return redirect('home');
    }
}
