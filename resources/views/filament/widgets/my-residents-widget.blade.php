<x-filament-widgets::widget>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-2 border-blue-500 dark:border-blue-400">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">My Residents</h3>
        <div class="space-y-4">
            @forelse($this->getResidents() as $resident)
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center gap-4">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $resident['name'] }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $resident['room'] }} - {{ $resident['branch'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium @if($resident['health_status'] == 'attention') text-red-600 @elseif($resident['health_status'] == 'caution') text-orange-600 @else text-green-600 @endif">
                            {{ ucfirst($resident['health_status']) }}
                        </span>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Last Vitals: {{ $resident['last_vitals'] }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-600 dark:text-gray-400 text-center">No residents assigned to you.</p>
            @endforelse
        </div>
        <div class="mt-6">
            <a href="{{ route('filament.admin.resources.residents.index') }}" 
               class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                View All Residents
            </a>
        </div>
    </div>
</x-filament-widgets::widget>
