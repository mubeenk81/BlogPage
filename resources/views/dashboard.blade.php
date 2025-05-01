<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-red-300">
                        Sign Out
                    </button>
                </form>
            @endauth
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                @auth
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __("You're logged in!") }}
                    </h3>
                    <p class="text-gray-600 mb-2">
                        Welcome back, {{ Auth::user()->name }}.
                    </p>

                    <!-- AlpineJS role toggle panel -->
                    <div x-data="{ show: true }" class="mt-4">
                        <button @click="show = !show"
                                class="text-sm text-indigo-600 hover:text-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-300 mb-2 flex items-center">
                            <svg x-show="!show" class="h-4 w-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 4v16m8-8H4"></path>
                            </svg>
                            <svg x-show="show" class="h-4 w-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 12H4"></path>
                            </svg>
                            <span x-text="show ? 'Hide role details' : 'Show role details'"></span>
                        </button>

                        <div x-show="show" x-transition class="p-4 border rounded bg-gray-50 text-sm text-gray-700">
                            @switch(Auth::user()->role)
                                @case('admin')
                                    <p>🔐 You are logged in as an <strong>Administrator</strong>. You have full access to the system.</p>
                                    @break

                                @case('editor')
                                    <p>📝 You are logged in as an <strong>Editor</strong>. You can manage posts and content.</p>
                                    @break

                                @case('user')
                                    <p>👤 You are logged in as a <strong>Regular User</strong>. You can browse and comment on posts.</p>
                                    @break

                                @default
                                    <p>👥 You have a <strong>custom role</strong>: {{ Auth::user()->role }}</p>
                            @endswitch
                        </div>
                    </div>
                @else
                    <h3 class="text-lg font-medium text-red-600 mb-4">
                        {{ __("Please log in.") }}
                    </h3>
                    <a href="{{ route('login') }}" class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded">
                        Go to Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
