@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Posts by {{ $user->name }}</h1>

    @if($posts->isEmpty())
        <p>No posts available.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 text-left">Post ID</th>
                    <th class="py-2 px-4 text-left">Publisher</th>
                    <th class="py-2 px-4 text-left">Title</th>
                    <th class="py-2 px-4 text-left">Created At</th>
                    <th class="py-2 px-4 text-left">Actions</th>
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
    @endif
</div>
@endsection
