<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>

    <form x-data="{ showPassword: false, loading: false }"
          x-on:submit="loading = true"
          method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email"
                          class="block mt-1 w-full"
                          type="email"
                          name="email"
                          :value="old('email')"
                          required
                          autofocus
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 transition duration-200 ease-in-out" />
        </div>

        <!-- Password with Toggle -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
            <x-text-input id="password"
              class="block mt-1 w-full pr-10"
              x-bind:type="showPassword ? 'text' : 'password'"
              name="password"
              required
              autocomplete="current-password" />

                
                <!-- Toggle Visibility Button -->
                <button type="button"
                        class="absolute inset-y-0 right-0 px-3 text-sm text-gray-600 hover:text-gray-800 focus:outline-none"
                        @click="showPassword = !showPassword"
                        :aria-label="showPassword ? 'Hide password' : 'Show password'">
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-.003.01-.003.02 0 .03-.002.01-.002.02 0 .03C20.268 16.057 16.478 19 12 19c-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.049 10.049 0 012.362-3.568M9.88 9.88a3 3 0 104.24 4.24M4.222 4.222l15.556 15.556" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2 transition duration-200 ease-in-out" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me"
                       type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Submit Button & Forgot Link -->
        <div class="flex items-center justify-end mt-4 space-x-3">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit"
                    class="ms-3 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    x-bind:disabled="loading"
                    x-text="loading ? 'Logging in...' : 'Log in'">
            </button>
        </div>
    </form>
</x-guest-layout>
