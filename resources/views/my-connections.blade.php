<x-app-layout>
    <div class="lg:col-span-3 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-succes />
            <x-connection-requests />
            <x-connections-list />
        </div>
</x-app-layout>

<script src="{{ asset('js/connection.js') }}" defer></script>