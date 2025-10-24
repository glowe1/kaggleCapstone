<x-filament-widgets::widget>
    <div class="p-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Recent Vital Signs</h3>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Latest vital signs recordings for your residents</p>
        </div>

        <!-- Vitals Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border-2 border-green-500 dark:border-green-400 overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="text-left p-6 text-sm font-semibold text-gray-900 dark:text-white">Resident</th>
                        <th class="text-left p-6 text-sm font-semibold text-gray-900 dark:text-white">Blood Pressure</th>
                        <th class="text-left p-6 text-sm font-semibold text-gray-900 dark:text-white">Heart Rate</th>
                        <th class="text-left p-6 text-sm font-semibold text-gray-900 dark:text-white">Temperature</th>
                        <th class="text-left p-6 text-sm font-semibold text-gray-900 dark:text-white">Oxygen</th>
                        <th class="text-left p-6 text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                        <th class="text-left p-6 text-sm font-semibold text-gray-900 dark:text-white">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($this->getRecentVitals() as $vital)
                        <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="p-6">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-full">
                                        <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $vital['resident'] }}</span>
                                </div>
                            </td>
                            <td class="p-6 text-gray-900 dark:text-white">{{ $vital['blood_pressure'] }}</td>
                            <td class="p-6 text-gray-900 dark:text-white">{{ $vital['heart_rate'] }} bpm</td>
                            <td class="p-6 text-gray-900 dark:text-white">{{ $vital['temperature'] }}°F</td>
                            <td class="p-6 text-gray-900 dark:text-white">{{ $vital['oxygen_saturation'] }}%</td>
                            <td class="p-6">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    @if($vital['status'] == 'high') bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400
                                    @elseif($vital['status'] == 'low') bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400
                                    @else bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400
                                    @endif">
                                    {{ ucfirst($vital['status']) }}
                                </span>
                            </td>
                            <td class="p-6 text-sm text-gray-500 dark:text-gray-400">{{ $vital['recorded_at']->format('M d, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-500 dark:text-gray-400">No recent vital signs recorded</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-filament-widgets::widget>
