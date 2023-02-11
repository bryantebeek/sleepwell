<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6 text-gray-900">
                    @if (session()->has('message'))
                        <div class="alert bg-purple-700 text-white">
                            {{ session('message') }}
                        </div>
                    @endif

                    <livewire:profile/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
