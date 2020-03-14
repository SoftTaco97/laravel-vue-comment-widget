<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comments;

class CommentsController extends Controller
{
    /**
     * Method for displaying the main comments page
     */
    public function show() 
    {
        return view('comments');
    }

    /**
     * Method for retrieving the last five comments from the database
     */
    public function retrieveComments() 
    {
        // ref: https://stackoverflow.com/questions/24860973/laravel-how-to-get-last-n-entries-from-db
        // That took some googling to figure out lol
        $comments = Comments::orderBy('id', 'desc')->take(5)->get();
        return $comments;
    }

    /**
     * Method for creating a new comment in a the database
     */
    public function createComment(Request $request) 
    {
        if($request->has(['name', 'email', 'comment'])) {
            $comment = new Comments();
            $comment->name = $request->name;
            $comment->email = $request->email;
            $comment->comment = $request->comment;
            $comment->save();
            return response(null, 204);
        }
        return response('Invalid information', 400);
    }
}
