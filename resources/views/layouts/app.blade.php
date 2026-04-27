<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      dir="{{ in_array(app()->getLocale(), ['ar']) ? 'rtl' : 'ltr' }}"
      x-data="{ theme: localStorage.getItem('theme') || 'light' }"
      :class="{ 'dark': theme === 'dark' }"
      @theme-changed.window="theme = $event.detail">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#f8fafc]">
        <div class="flex min-h-screen overflow-x-hidden">
            <!-- Sidebar -->
            <div class="hidden lg:block w-[340px] flex-shrink-0">
                @include('layouts.parts.sidebar')
            </div>
            
            <!-- Mobile Sidebar Overlay (Alpine.js handled inside sidebar) -->
            <div class="lg:hidden">
                @include('layouts.parts.sidebar')
            </div>

            <div class="flex-1 flex flex-col min-w-0">
                <!-- Header -->
                @include('layouts.parts.header')

                <!-- Page Content -->
                <main class="flex-1 p-4 md:p-8 lg:p-12">
                    <!-- Session Feedback -->
                    @if(session('success'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                             class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-3xl flex items-center justify-between shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-emerald-500 rounded-xl flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span class="text-sm font-bold text-emerald-800">{{ session('success') }}</span>
                            </div>
                            <button @click="show = false" class="text-emerald-400 hover:text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endif

                    {{ $slot }}
                </main>

                <!-- Footer -->
                @include('layouts.parts.footer')
            </div>
        </div>
    </body>
</html>
