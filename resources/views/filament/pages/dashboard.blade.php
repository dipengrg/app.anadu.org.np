<x-filament-panels::page>
    <div class="fi-section rounded-xl bg-white p-6 shadow-sm dark:bg-gray-900">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-semibold">Dashboard</h2>
                <p class="mt-1 text-sm text-gray-500">You are signed in to the admin panel.</p>
            </div>

            <form method="POST" action="{{ $this->getLogoutUrl() }}">
                @csrf
                <x-filament::button type="submit" color="gray">
                    Logout
                </x-filament::button>
            </form>
        </div>
    </div>
</x-filament-panels::page>