<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $comments = Comment::with('author')->whereNull('parent_id')->get();
        $subComments = Comment::with('author')->whereNotNull('parent_id')->get();
        return view('home', compact('comments', 'subComments'));

    }
}
