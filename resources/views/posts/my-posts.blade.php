@extends('layouts.app')

@section('title', 'My Posts')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-xl font-semibold mb-4">My Posts</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Id</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Title</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Date</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($posts as $post)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $post->id }}</td>
                        <td class="py-2 px-4">{{ $post->title }}</td>
                        <td class="py-2 px-4">{{ $post->created_at->format('d-m-Y') }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                            <a href="{{ route('posts.edit', $post->id) }}" class="text-green-600 ml-2">Edit</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
