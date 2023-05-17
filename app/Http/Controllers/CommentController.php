<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        // Retrieve all comments from the database
        $comments = Comment::all();

        // Return the comments as a response
        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        try {

            // Validate the incoming request data
            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email',
                'comment' => 'required|string',
            ]);


            // Create a new comment instance and save it to the database
            $comment = new Comment;
            $comment->name = $request->input('name');
            $comment->email = $request->input('email');
            $comment->comment = $request->input('comment');
            $comment->save();

            // Return a response indicating the comment has been saved
            return response()->json('Comment saved successfully', 201);
        } catch (ValidationException $e) {
            // Handle validation exception and return a fail response
            return response()->json(["error" => $e->errors()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
