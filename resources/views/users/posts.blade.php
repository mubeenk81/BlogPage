@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Posts by {{ $user->name }}</h1>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>

    @if($posts->isEmpty())
        <p class="text-gray-600">No posts available.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded shadow">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th scope="col" class="py-3 px-4 text-left text-sm font-medium">#</th>
                        <th scope="col" class="py-3 px-4 text-left text-sm font-medium">Publisher</th>
                        <th scope="col" class="py-3 px-4 text-left text-sm font-medium">Title</th>
                        <th scope="col" class="py-3 px-4 text-left text-sm font-medium">Created</th>
                        <th scope="col" class="py-3 px-4 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 divide-y divide-gray-200">
                    @foreach($posts as $post)
                        <tr x-data="{ expanded: false }" class="transition duration-200 hover:bg-gray-50">
                            <td class="py-3 px-4 text-sm">{{ $post->id }}</td>
                            <td class="py-3 px-4 text-sm">
                                @if($post->user)
                                    <a href="{{ route('users.posts', $post->user->id) }}" class="text-blue-600 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-300">
                                        {{ $post->user->name }}
                                    </a>
                                @else
                                    <span class="text-gray-500 italic">Unknown Publisher</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-sm">
                                <button @click="expanded = !expanded"
                                        class="text-left w-full text-indigo-600 hover:text-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                                        :aria-expanded="expanded"
                                        :aria-controls="'post-content-' + {{ $post->id }}">
                                    {{ $post->title }}
                                </button>
                            </td>
                            <td class="py-3 px-4 text-sm">{{ $post->created_at->format('d-m-Y') }}</td>
                            <td class="py-3 px-4 text-sm space-x-2">
                                <a href="{{ route('posts.show', $post->id) }}"
                                   class="text-blue-600 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300"
                                   aria-label="View Post {{ $post->title }}">
                                    View
                                </a>

                                @if(auth()->check() && auth()->id() === $post->user_id)
                                    <a href="{{ route('posts.edit', $post->id) }}"
                                       class="text-green-600 hover:text-green-800 focus:outline-none focus:ring-2 focus:ring-green-300"
                                       aria-label="Edit Post {{ $post->title }}">
                                        Edit
                                    </a>

                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-300"
                                                aria-label="Delete Post {{ $post->title }}">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                        <!-- Expandable Row Content -->
                        <tr x-show="expanded" x-transition x-cloak>
                            <td colspan="5" class="bg-gray-50 px-4 py-3 text-sm text-gray-600 border-t border-b">
                                <strong>Post Preview:</strong> {{ Str::limit($post->body ?? 'No content available.', 150) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
