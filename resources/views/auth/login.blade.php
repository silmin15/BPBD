<x-guest-layout>
    {{-- Ini adalah wadah utama form, dengan latar belakang putih semi-transparan, rounded, dan shadow --}}
    <div class="w-full sm:max-w-md px-6 py-8 bg-white/80 shadow-md overflow-hidden sm:rounded-lg backdrop-blur-sm">

        <!-- Logo dan Judul -->
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('images/logo-bpbd.png') }}" alt="Logo BPBD" class="w-24 h-24 mb-4">
            <h2 class="text-2xl font-bold text-gray-800">BPBD Banjarnegara</h2>
            <p class="text-gray-600">Hai, Selamat Datang di sistem BPBD</p>
        </div>

        <!-- Session Status (Pesan seperti "Password berhasil direset") -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username / E-mail -->
            <div>
                <x-input-label for="email" value="Username / E-mail" class="font-bold" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Lorem123 atau Lorem@gmail.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" value="Password" class="font-bold" />
                <x-text-input id="password" class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required autocomplete="current-password"
                    placeholder="Lorem123124234" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Ingat Saya & Lupa Kata Sandi -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                </label>

                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Lupa kata sandi ?') }}
                </a>
                @endif
            </div>

            <!-- Tombol Login -->
            <div class="flex items-center justify-center mt-6">
                <x-primary-button class="w-full text-center flex justify-center bg-blue-800 hover:bg-blue-900">
                    {{ __('Login') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>