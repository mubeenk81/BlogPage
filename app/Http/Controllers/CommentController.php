<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\CommentNotification;
use Illuminate\Support\Facades\Notification;    

class CommentController extends Controller
{
    //

public function store(Request $request, Post $post)
{
    // Validate the content and tags
    $validated = $request->validate([
        'content' => 'required|string|max:1000',
        'tags' => 'nullable|array',  // Validate tags if provided
        'tags.*' => 'exists:tags,id', // Ensure each tag ID exists in the tags table
    ]);

    // Create the comment
    $comment = $post->comments()->create([
        'user_id' => auth()->id(),
        'user_name' => $request->name,
        'content' => $validated['content'],
    ]);

    // Attach tags to the comment (if any)
    if (isset($validated['tags'])) {
        $comment->tags()->attach($validated['tags']); // Attach tags to the comment
    }
    //Notification
    $postCreator = $post->user;  // Assuming the 'user' relationship is defined in your Post model
    if (auth()->id() !== $postCreator->id) {
        Notification::send($postCreator, new CommentNotification($request->name, $post->title));
    }
    // Notification::send($postCreator, new CommentNotification($request->name,$post->title));

    
    // Check if the request is AJAX
    if ($request->ajax()) {
        return response()->json([
            'message' => 'Comment posted successfully!',
            'comment' => $comment,
            'user' => $comment->user->name,
            'tags' => $comment->tags->pluck('name'), // Include tag names if needed
            'created_at' => $comment->created_at->format('d-m-Y'),
        ], 201); // Status code 201: Created
    }

    // Redirect back to the previous page if not an AJAX request
    return redirect()->back()->with('success', 'Comment posted successfully!');
}

    
    
    public function edit($commentId) {
        $comment = Comment::findOrFail($commentId);
    
        // Allow only the comment author to edit
        if (auth()->id() !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        return view('comments.edit', compact('comment'));
    }
    public function update(Request $request, $commentId) {
        $comment = Comment::findOrFail($commentId);
    
        if (auth()->id() !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        $request->validate([
            'content' => 'required|string',
        ]);
    
        $comment->update([
            'content' => $request->content,
        ]);
    
        return redirect()->route('posts.show', $comment->post_id);
    }
    
    public function destroy($commentId) {
        $comment = Comment::findOrFail($commentId);
        $post = Post::findOrFail($comment->post_id);
    
        // Allow deletion if the user is the comment author or post author
        if (auth()->id() !== $comment->user_id && auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        $comment->delete();
    
        return redirect()->route('posts.show', $post->id);
    }
}
