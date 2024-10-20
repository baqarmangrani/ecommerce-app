<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @auth
                        <h3 class="text-lg font-semibold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                        <p>Use the navigation to switch between sections.</p>
                    @else
                        <h3 class="text-lg font-semibold mb-4">Welcome to Ecommerce App by 247Labs</h3>
                        <p>Please <a href="{{ route('login') }}" class="text-blue-500 underline">log in</a> or <a
                                href="{{ route('register') }}" class="text-blue-500 underline">register</a> to continue.</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
