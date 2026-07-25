<x-filament-panels::page>
    <div class="fi-section rounded-xl bg-white p-6 shadow-sm dark:bg-gray-900 space-y-4">
        <h2 class="text-lg font-semibold">Welcome back</h2>

        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-sm text-gray-500">Mobile Number</dt>
                <dd class="font-medium">{{ $this->getUser()->mobile_number }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Email</dt>
                <dd class="font-medium">{{ $this->getUser()->email ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Role</dt>
                <dd class="font-medium capitalize">{{ $this->getUser()->role }}</dd>
            </div>
        </dl>

        <form method="POST" action="{{ $this->getLogoutUrl() }}">
            @csrf
            <x-filament::button type="submit" color="danger">
                Logout
            </x-filament::button>
        </form>
    </div>
</x-filament-panels::page>