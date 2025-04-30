@extends('layouts.app')

@section('title') Index @endsection

@section('content')
<!-- Post Form -->
<div class="container mx-auto mt-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h5 class="text-lg font-semibold mb-4">Create a Post</h5>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            
        <!-- <form id="postForm" enctype="multipart/form-data"> -->
        @csrf
            <!-- Textbox for the title -->
            <div class="mb-4">
                <label for="postTitle" class="block text-sm font-medium text-gray-700">Post Title</label>
                <input name="title" type="text" class="mt-1 p-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500" id="postTitle" placeholder="Enter the title of your post">
                @error('title')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Text area for the post content -->
            <div class="mb-4">
                <label for="postText" class="block text-sm font-medium text-gray-700">Post Content</label>
                <textarea name="content" class="mt-1 p-2 border border-gray-300 rounded-md w-full focus:ring-blue-500 focus:border-blue-500" id="postText" rows="3" placeholder="What's on your mind?"></textarea>
                @error('content')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>

           <!-- Tags Dropdown -->
            <div class="mb-4">
                <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                <select name="tags[]" id="tags" multiple class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    @foreach ($allTags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">Hold down the Ctrl (Windows) or Command (Mac) key to select multiple tags.</p>
                @error('tags')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
            </div>
 
            <!-- Image Input with Custom Button Style -->
            <div class="mb-4">
                <label for="postImage" class="block text-sm font-medium text-gray-700 mb-2">Upload Image</label>
                <label for="postImage" class="cursor-pointer inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 3a1 1 0 100 2h12a1 1 0 100-2H4zM3 8a1 1 0 011-1h12a1 1 0 011 1v5a3 3 0 11-6 0H8a3 3 0 11-6 0V8zm7 5a1 1 0 11-2 0 1 1 0 012 0z"></path>
                    </svg>
                    Choose File
                </label>
                <input type="file" name="photo" id="postImage" class="hidden">
            </div>

            <!-- Post Button -->
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Post</button>
        </form>

        <script>
            function submitPost() {
                var formData = new FormData($('#postForm')[0]);

                $.ajax({
                    url: "{{ route('posts.store') }}",  // Adjust to your actual route name
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert('Post created successfully!');
                        $('#postForm')[0].reset();  // Clear form fields
                        // Optionally, you could refresh or update the posts list here
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            }
        </script>

    </div>
</div>

<!-- Post Table -->
<div class="container mx-auto mt-8">
    <h2 class="text-xl font-semibold mb-4">List of Posts</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th scope="col" class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Id</th>
                    <th scope="col" class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Publisher</th>
                    <th scope="col" class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Title</th>
                    <th scope="col" class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Date</th>
                    <th scope="col" class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($posts as $post)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $post->id }}</td>
                        <td class="py-2 px-4">
                            @if($post->user)
                                <a href="{{ route('users.posts', $post->user->id) }}" class="text-blue-500 hover:text-blue-700">
                                    {{ $post->user->name }}
                                </a>
                            @else
                                Unknown Publisher
                            @endif
                        </td> <!-- Display Publisher's Name as a Link -->
                        <td class="py-2 px-4">{{ $post['title'] }}</td>
                        <td class="py-2 px-4">{{ $post->created_at->format('d-m-Y') }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ route('posts.show', $post['id']) }}" class="text-blue-500 hover:text-blue-700 mr-2">View</a>
                            @if(auth()->check() && auth()->id() === $post->user_id)
                                <a href="{{ route('posts.edit', $post->id) }}" class="text-green-600">Edit</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
