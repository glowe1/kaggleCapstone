<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Profile Information Form --}}
        <form wire:submit="save">
            {{ $this->form }}
            
            <div class="mt-4 flex justify-end">
                <x-filament::button type="submit">
                    Save Profile
                </x-filament::button>
            </div>
        </form>

        {{-- Password Change Form --}}
        <form wire:submit="changePassword">
            {{ $this->passwordForm }}
            
            <div class="mt-4 flex justify-end">
                <x-filament::button type="submit" color="warning">
                    Change Password
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>

