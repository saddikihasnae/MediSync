<x-app-layout>
    <x-slot name="header">
        {{ __('messages.dashboard') }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            {{ __('messages.welcome') }}, {{ Auth::user()->name }}!
        </div>
    </div>
</x-app-layout>
