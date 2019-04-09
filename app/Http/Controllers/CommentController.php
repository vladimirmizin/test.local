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

        $input['user_id'] = $request->user()->id;
        $input['title'] = $request->get('title');
        $input['body'] = $request->get('body');

        Comment::create($input);
        return back();
    }
    protected function addSubComment (Request $request, $parent_id, $title) {
        $this->validate($request, [
            'body' => 'required|min:1',
        ]);
        $input['user_id'] = $request->user()->id;
        $input['title'] = $title;
        $input['body'] = $request->get('body');
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
        $comment = Comment::find($id);
        if ((Carbon::now()->subMinutes(60)->lt($comment->created_at))){
            return view('edit')->with('comment', $comment);
        }
        else{
            return back();
        }


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
        if (($comment->user_id == auth()->user()->id )&& ((Carbon::now()->subMinutes(60)->lt($comment->created_at)))) {
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
        if ($comment && ($comment->user_id == $request->user()->id )) {
            $comment->delete();
        }
        return redirect('home');
    }
}
