@extends('layouts.app')

@section('title') Show @endsection

@section('content')
<!-- Post Section -->
<div class="container mx-auto mt-8">
    <!-- Single Post -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="mb-4">
            <h5 class="text-xl font-semibold text-gray-800">Publisher:</h5>
            <p class="text-lg text-gray-700">{{ $post->user->name ?? 'Unknown Publisher' }}</p> <!-- Post author -->
        </div>

            <!-- Tags -->
        <div class="tags mt-4">
            <h5 class="text-lg font-medium">Tags:</h5>
            @if ($post->tags->isNotEmpty())
                <ul class="list-inline">
                    @foreach ($post->tags as $tag)
                        <li class="inline-block bg-blue-200 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                            {{ $tag->name }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">No tags for this post.</p>
            @endif
        </div>
        <div class="mb-4">
            <h6 class="text-xl font-semibold text-gray-800">Title:</h6>
            <p class="text-lg text-gray-700">{{ $post['title'] }}</p> <!-- Post title -->
        </div>

        <div class="mb-4">
            <h6 class="text-xl font-semibold text-gray-800">Posted on:</h6>
            <p class="text-sm text-gray-500">{{ $post->created_at->format('d-m-Y') }}</p> <!-- Post date -->
        </div>
        
        <div class="mb-4">
            <h6 class="text-xl font-semibold text-gray-800">Content:</h6>
            <p class="text-gray-700 mt-2">{{ $post['content'] }}</p> <!-- Post content -->
        </div>

        <!-- Optional display of the post's image if it exists -->
        @if($post->photo)
        <div class="mb-4">
                <img src="{{ asset('storage/' . $post->photo) }}" alt="Post Image" class="w-32 h-32 object-cover rounded-md mt-2">
            </div>
        @endif
    </div>
</div>


    </div>

    <!-- Comments Section -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h6 class="text-lg font-semibold text-gray-800 mb-4">Comments</h6>

        <!-- Display Existing Comments -->
        @foreach($post->comments as $comment)
            <div class="border p-4 mb-2 rounded-lg">
                <p><strong>{{ $comment->user->name }}</strong> - {{ $comment->created_at->format('d-m-Y') }}</p>
                <p>{{ $comment->content }}</p>
                <!-- Displaying tags for a comment -->

                <!-- Tags for this comment -->
                <h3>Tags:</h3>
                    @if ($comment->tags->isNotEmpty())
                        <ul>
                            @foreach($comment->tags as $tag)
                                <li>{{ $tag->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No tags for this comment.</p>
                    @endif
                <!-- Show Edit and Delete buttons based on user permissions -->
                <div class="flex space-x-2 mt-2">
                    @if(auth()->check() && auth()->id() === $comment->user_id)
                        <!-- Edit button for the comment author only -->
                        <a href="{{ route('comments.edit', $comment->id) }}" class="text-blue-500 hover:underline">Edit</a>
                    @endif


                    @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->id() === $post->user_id))
                        <!-- Delete button for the comment author or post author -->
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach

        <!-- Leave a Comment Form -->
        <!-- Leave a Comment Form -->
        <form id="comment-form" action="{{ route('comments.store', ['post' => $post->id]) }}" method="POST">
            @csrf
            <div class="mb-4">
                <textarea name="content" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="2" placeholder="Leave a comment"></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                Post Comment
            </button>
        </form>

    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    // Handle comment submission with AJAX
    $('#comment-form').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        var content = $('textarea[name="content"]').val(); // Get the comment content
        var errorContainer = $('#comment-error'); // Error container

        $.ajax({
            url: '{{ route('comments.store', ['post' => $post->id]) }}',
            method: 'POST',
            data: {
                _token: $('input[name="_token"]').val(), // CSRF token
                content: content,
            },
            success: function (response) {
                // Clear error messages
                errorContainer.addClass('hidden').text('');

                // Append the new comment to the comments section
                if (response.comment) {
                    var tagsHtml = '';
                    if (response.tags && response.tags.length > 0) {
                        tagsHtml = '<h3>Tags:</h3><ul>';
                        response.tags.forEach(function (tag) {
                            tagsHtml += `<li>${tag}</li>`;
                        });
                        tagsHtml += '</ul>';
                    }

                    var commentHtml = `
                        <div class="border p-4 mb-2 rounded-lg" id="comment-${response.comment.id}">
                            <p><strong>${response.user}</strong> - ${response.created_at}</p>
                            <p>${response.comment.content}</p>
                            ${tagsHtml}
                        </div>
                    `;
                    $('#comment-form').before(commentHtml); // Add the new comment before the form

                    // Clear the textarea after posting
                    $('textarea[name="content"]').val('');
                } else {
                    alert('Something went wrong!');
                }
            },
            error: function (xhr) {
                // Handle validation errors
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.content) {
                        errorContainer.removeClass('hidden').text(errors.content[0]);
                    }
                } else {
                    console.error(xhr.responseText);
                    alert('An error occurred while posting the comment.');
                }
            },
        });
    });
});
</script>


@endsection
