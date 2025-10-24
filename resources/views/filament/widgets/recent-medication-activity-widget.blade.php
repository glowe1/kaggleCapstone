<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Recent Medication Activity
        </x-slot>
        
        <x-slot name="description">
            Latest medication administrations
        </x-slot>

        @php
            $recentAdministrations = $this->getViewData()['recentAdministrations'] ?? collect();
        @endphp

        @if($recentAdministrations->count() > 0)
            <div class="space-y-3">
                @foreach($recentAdministrations as $administration)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                @if($administration->status === 'completed')
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <x-heroicon-o-check class="w-5 h-5 text-green-600" />
                                    </div>
                                @elseif($administration->status === 'missed')
                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <x-heroicon-o-clock class="w-5 h-5 text-yellow-600" />
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                        <x-heroicon-o-x-mark class="w-5 h-5 text-red-600" />
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $administration->medication->name ?? 'Unknown Medication' }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $administration->resident->name ?? 'Unknown Resident' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500">{{ $administration->administered_at->format('M j, Y g:i A') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($administration->status === 'completed') bg-green-100 text-green-800
                                @elseif($administration->status === 'missed') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($administration->status) }}
                            </span>
                            @if($administration->administeredBy)
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">by {{ $administration->administeredBy->name }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <x-heroicon-o-cube class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-4" />
                <p class="text-gray-500 dark:text-gray-400 text-lg">No medication history found</p>
                <p class="text-gray-400 dark:text-gray-500 text-sm">Medication administrations will appear here once recorded</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
