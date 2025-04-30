@extends('layouts.app')

@section('title') Edit @endsection

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h5 class="text-2xl font-semibold text-gray-800 mb-6">Edit Post</h5>
        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Textbox for the title -->
            <div class="mb-4">
                <label for="postTitle" class="block text-gray-700 font-semibold mb-2">Post Title</label>
                <input name="title" type="text" value="{{ $post['title'] }}" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="postTitle" placeholder="Enter the title of your post">
            </div>

            <!-- Text area for the post content -->
            <div class="mb-4">
                <label for="postText" class="block text-gray-700 font-semibold mb-2">Post Content</label>
                <textarea name="content" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="postText" rows="3" placeholder="What's on your mind?">{{ $post['content'] }}</textarea>
            </div>

            <!-- Update Button -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Update</button>
        </form>
    </div>
</div>
@endsection
