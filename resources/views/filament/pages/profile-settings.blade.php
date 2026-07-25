<x-filament-panels::page>
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="fi-section rounded-xl bg-white p-6 shadow-sm dark:bg-gray-900">
            <h2 class="text-lg font-semibold">Profile</h2>
            <p class="mt-1 text-sm text-gray-500">Update your personal details.</p>

            <form method="POST" action="{{ route('profile-settings.update') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700" for="name">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', auth()->user()?->name ?? '') }}" class="fi-input w-full rounded-lg border border-gray-300 px-3 py-2" />
                    @error('name')
                        <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700" for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', auth()->user()?->email ?? '') }}" class="fi-input w-full rounded-lg border border-gray-300 px-3 py-2" />
                    @error('email')
                        <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                <x-filament::button type="submit" name="action" value="profile">
                    Save profile
                </x-filament::button>
            </form>
        </div>

        <div class="fi-section rounded-xl bg-white p-6 shadow-sm dark:bg-gray-900">
            <h2 class="text-lg font-semibold">Change password</h2>
            <p class="mt-1 text-sm text-gray-500">Use a strong password you have not used before.</p>

            <form method="POST" action="{{ route('profile-settings.update') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700" for="current_password">Current password</label>
                    <input id="current_password" name="current_password" type="password" class="fi-input w-full rounded-lg border border-gray-300 px-3 py-2" />
                    @error('current_password')
                        <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700" for="password">New password</label>
                    <input id="password" name="password" type="password" class="fi-input w-full rounded-lg border border-gray-300 px-3 py-2" />
                    @error('password')
                        <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700" for="password_confirmation">Confirm new password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="fi-input w-full rounded-lg border border-gray-300 px-3 py-2" />
                </div>

                <x-filament::button type="submit" name="action" value="password">
                    Change password
                </x-filament::button>
            </form>
        </div>
    </div>
</x-filament-panels::page>
