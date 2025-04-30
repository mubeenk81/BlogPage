@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <!-- User Profile Section -->
    <div class="flex items-center mb-6">
        <div class="w-16 h-16 rounded-full overflow-hidden mr-4">
            @if($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}'s Profile Picture" class="w-full h-full object-cover">
            @else
                <i class="fas fa-user-circle text-gray-700 text-4xl"></i> <!-- Default Icon -->
            @endif
        </div>
        <div>
            <h1 class="text-2xl font-semibold">{{ $user->name }}</h1>
            <p class="text-gray-600">{{ $user->email }}</p>
        </div>
    </div>

    <!-- Posts Section -->
    <!-- <div class="bg-white p-4 rounded-lg shadow-sm">
        <h2 class="text-xl font-semibold mb-4">Posts by {{ $user->name }}</h2>
        
        @if($posts->isEmpty())
            <p class="text-gray-500">No posts available.</p>
        @else
            <ul class="space-y-4">
                @foreach($posts as $post)
                    <li class="border-b pb-4">
                        <h3 class="font-semibold text-lg">
                            <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500 hover:text-blue-700">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-600">{{ Str::limit($post->content, 100) }}</p>
                        <p class="text-sm text-gray-500">Posted on {{ $post->created_at->format('d-m-Y') }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div> -->
</div>
@endsection
