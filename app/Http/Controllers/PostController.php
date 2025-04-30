<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;


class PostController extends Controller
{
    public function index() {
        // $postsFromDB = Post::all();
        // $users = User::all();
        // $posts = Post::with('user')->get();
        
        $posts = Post::orderBy('created_at', 'desc')->get();
            // Fetch all posts and tags
        $allTags = Tag::all(); // Retrieve all tags
        return view('posts.index', compact('posts', 'allTags'));
        
    }

    public function show($postId){
        // SELECT * FROM posts WHERE id = $postID
        // $singlePostFromDB = Post::with('user')->findOrFail($postId);
        $singlePostFromDB = Post::with(['user', 'tags'])->findOrFail($postId);

        // $singlePostFromDB = Post::where('id', $postId) -> first(); 
        // $singlePostFromDB = Post::where('id', $postId) -> get();
        // if(is_null($singlePostFromDB)){
        //     return to_route('posts.index');
        // }
        return view('posts.show', ['post' =>  $singlePostFromDB]);
    }

    public function store(Request $request)
    {
        // Validate the request and store validated data in $validated
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'array', // Validate that tags is an array
            'tags.*' => 'exists:tags,id', // Ensure each tag exists
        ], [
            'title.required' => 'The post title is required.',
            'content.required' => 'You must write some content for the post.',
        ]);
    
        $user = auth()->user(); // Retrieve the authenticated user
    
        // Create the post
        $post = new Post;
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->user_id = $user->id;
    
        // Check if an image file is uploaded and store it
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $post->photo = $path;
        }
    
        $post->save();
    
        // Attach tags to the post
        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }
    
        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }
    

    public function edit($postId) {
        $post = Post::findOrFail($postId);
    
        // Check if the authenticated user is the owner
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        return view('posts.edit', compact('post'));
    }
    
    public function update(Request $request, $postId) {
        $post = Post::findOrFail($postId);
    
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);
    
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);
    
        return to_route('posts.index');
    }
    
    public function destroy($postId) {
        $post = Post::findOrFail($postId);
    
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        $post->delete();
    
        return to_route('posts.index');
    }
    // Delete a post
    // public function destroy(Post $post)
    // {
    //     if (Gate::allows('delete-posts', $post)) {
    //         $post->delete();
    //         return redirect()->back()->with('success', 'Post deleted!');
    //     }

    //     abort(403, 'Unauthorized action.');
    // }

    public function myPosts()
    {
        // Fetch posts by the authenticated user
        $posts = Post::where('user_id', auth()->id())->get();
        
        // Return view with the user's posts
        return view('posts.my-posts', compact('posts'));
    }

}    
