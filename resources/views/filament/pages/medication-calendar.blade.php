<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Calendar Navigation -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ \Carbon\Carbon::parse($this->selectedDate)->format('F Y') }}
                </h2>
                <div class="flex items-center space-x-3">
                    <button 
                        wire:click="selectDate('{{ \Carbon\Carbon::parse($this->selectedDate)->subMonth()->format('Y-m-d') }}')"
                        class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <x-heroicon-o-chevron-left class="h-5 w-5" />
                    </button>
                    <button 
                        wire:click="selectDate('{{ now()->format('Y-m-d') }}')"
                        class="px-4 py-2 text-sm font-medium bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                        Today
                    </button>
                    <button 
                        wire:click="selectDate('{{ \Carbon\Carbon::parse($this->selectedDate)->addMonth()->format('Y-m-d') }}')"
                        class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <x-heroicon-o-chevron-right class="h-5 w-5" />
                    </button>
                </div>
            </div>

            <!-- Simple Calendar Grid -->
            <div class="grid grid-cols-7 gap-2">
                <!-- Day Headers -->
                <div class="p-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 rounded">Sun</div>
                <div class="p-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 rounded">Mon</div>
                <div class="p-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 rounded">Tue</div>
                <div class="p-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 rounded">Wed</div>
                <div class="p-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 rounded">Thu</div>
                <div class="p-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 rounded">Fri</div>
                <div class="p-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 rounded">Sat</div>

                <!-- Calendar Days -->
                @foreach($this->getCalendarDataProperty() as $day)
                    @php
                        $expectedDoses = $day['expectedDoses'] ?? $day['medicationCount'];
                        $allCompleted = $day['medicationCount'] > 0 && $day['completedCount'] === $expectedDoses && $expectedDoses > 0;
                        $someCompleted = $day['medicationCount'] > 0 && $day['completedCount'] > 0 && $day['completedCount'] < $expectedDoses;
                        $noneCompleted = $day['medicationCount'] > 0 && $day['completedCount'] === 0;
                    @endphp
                    
                    <button
                        wire:click="selectDate('{{ $day['date'] }}')"
                        class="p-4 text-center rounded-xl border-2 transition-all duration-200 hover:bg-teal-50 dark:hover:bg-teal-900/20
                            {{ $day['isSelected'] ? 'bg-teal-600 text-white border-teal-600 shadow-2xl transform scale-105' : 'border-gray-300 dark:border-gray-600' }}
                            {{ !$day['isSelected'] && $day['isToday'] ? 'bg-teal-100 dark:bg-teal-900/30 text-teal-800 dark:text-teal-300 border-teal-300 shadow-lg' : '' }}
                            {{ !$day['isCurrentMonth'] ? 'text-gray-400 dark:text-gray-600' : 'text-gray-900 dark:text-white' }}
                            {{ $allCompleted && !$day['isSelected'] ? 'bg-green-200 border-green-400 text-green-900 font-bold shadow-lg' : '' }}
                            {{ $someCompleted && !$day['isSelected'] ? 'bg-orange-200 border-orange-400 text-orange-900 font-bold shadow-lg' : '' }}
                            {{ $noneCompleted && !$day['isSelected'] ? 'bg-red-200 border-red-400 text-red-900 font-bold shadow-lg' : '' }}">
                        
                        <div class="text-lg font-bold {{ $day['isSelected'] ? 'text-white' : 'text-gray-900 dark:text-white' }}">
                            {{ $day['day'] }}
                        </div>
                        
                        @if($day['isSelected'])
                            <div class="mt-1">
                                <div class="inline-flex items-center px-2 py-1 bg-white text-teal-700 rounded-lg text-xs font-bold">
                                    SELECTED
                                </div>
                            </div>
                        @elseif($day['medicationCount'] > 0)
                            <div class="mt-1">
                                <div class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-bold border-2 shadow-sm
                                    {{ $allCompleted ? 'bg-green-300 text-green-900 border-green-600' : '' }}
                                    {{ $someCompleted ? 'bg-orange-300 text-orange-900 border-orange-600' : '' }}
                                    {{ $noneCompleted ? 'bg-red-300 text-red-900 border-red-600' : '' }}">
                                    {{ $day['completedCount'] }}/{{ $day['expectedDoses'] ?? $day['medicationCount'] }}
                                </div>
                            </div>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Selected Date Medications -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Medications for {{ \Carbon\Carbon::parse($this->selectedDate)->format('M d, Y') }}
                        </h3>
                        @if($this->selectedResident)
                            @php
                                $resident = \App\Models\Resident::find($this->selectedResident);
                            @endphp
                            @if($resident)
                                <div class="flex items-center justify-between">
                                    <p class="text-lg font-bold text-teal-800 bg-teal-100 px-4 py-2 rounded-lg border-2 border-teal-400">
                                        <x-heroicon-o-user class="h-5 w-5 inline mr-2" />
                                        Showing medications for {{ $resident->name }}
                                    </p>
                                    <button
                                        wire:click="$set('selectedResident', null)"
                                        class="px-4 py-2 text-sm font-bold bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                        Show All Residents
                                    </button>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ count($this->getMedicationsProperty()) }} medication(s) scheduled
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if(count($this->getMedicationsProperty()) > 0)
                    <div class="space-y-4">
                        @foreach($this->getMedicationsProperty() as $medication)
                            @php
                                $administrations = $medication->administrations;
                                $completedCount = $administrations->where('status', 'completed')->count();
                                $missedCount = $administrations->where('status', 'missed')->count();
                                $refusedCount = $administrations->where('status', 'refused')->count();
                                $totalAdministrations = $administrations->count();
                                
                                // Determine overall status
                                $overallStatus = 'pending';
                                if ($completedCount > 0) {
                                    $overallStatus = 'completed';
                                } elseif ($missedCount > 0) {
                                    $overallStatus = 'missed';
                                } elseif ($refusedCount > 0) {
                                    $overallStatus = 'refused';
                                }
                                
                                // Get medication times for this day
                                $medicationTimes = [];
                                if ($medication->time_1) $medicationTimes[] = \Carbon\Carbon::parse($medication->time_1)->format('g:i A');
                                if ($medication->time_2) $medicationTimes[] = \Carbon\Carbon::parse($medication->time_2)->format('g:i A');
                                if ($medication->time_3) $medicationTimes[] = \Carbon\Carbon::parse($medication->time_3)->format('g:i A');
                                if ($medication->time_4) $medicationTimes[] = \Carbon\Carbon::parse($medication->time_4)->format('g:i A');
                            @endphp
                            
                            <div class="border-4 rounded-2xl shadow-2xl
                                {{ $overallStatus === 'completed' ? 'bg-green-200 border-green-600 shadow-green-400' : '' }}
                                {{ $overallStatus === 'missed' ? 'bg-red-200 border-red-600 shadow-red-400' : '' }}
                                {{ $overallStatus === 'refused' ? 'bg-yellow-200 border-yellow-600 shadow-yellow-400' : '' }}
                                {{ $overallStatus === 'pending' ? 'bg-white border-gray-500 shadow-gray-400' : '' }}">
                                
                                <!-- Medication Header -->
                                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                @if($overallStatus === 'completed')
                                                    <x-heroicon-o-check-circle class="h-6 w-6 text-green-600" />
                                                @elseif($overallStatus === 'missed')
                                                    <x-heroicon-o-x-circle class="h-6 w-6 text-red-600" />
                                                @elseif($overallStatus === 'refused')
                                                    <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-yellow-600" />
                                                @else
                                                    <x-heroicon-o-clock class="h-6 w-6 text-gray-400" />
                                                @endif
                                            </div>
                                            
                                            <div>
                                                <h4 class="font-black text-gray-900 text-2xl">
                                                    {{ $medication->name }}
                                                </h4>
                                                <p class="text-lg font-bold text-gray-800">
                                                    <strong>{{ $medication->resident->name }}</strong> • {{ $medication->drug->strength ?? 'N/A' }}
                                                </p>
                                                <p class="text-base font-semibold text-gray-700 mt-2">
                                                    {{ $medication->instructions }} • {{ $medication->quantity }} units
                                                </p>
                                                @if(count($medicationTimes) > 0)
                                                    <div class="mt-2">
                                                        <p class="text-lg font-black text-teal-900 mb-3">
                                                            <strong>Scheduled Times:</strong>
                                                        </p>
                                                        <div class="flex flex-wrap gap-3">
                                                            @foreach($medicationTimes as $time)
                                                                <span class="px-4 py-3 bg-teal-300 text-teal-900 rounded-xl text-lg font-black border-4 border-teal-600 shadow-lg">
                                                                    {{ $time }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-gray-900">
                                                {{ $completedCount }}/{{ count($medicationTimes) }} completed
                                            </div>
                                            @if($totalAdministrations > 0)
                                                <div class="text-sm font-semibold text-gray-700">
                                                    {{ $totalAdministrations }} administration(s) today
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Administration History -->
                                @if($totalAdministrations > 0)
                                    <div class="p-4 bg-gray-50 dark:bg-gray-900/50">
                                        <h5 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Today's Administrations:</h5>
                                        <div class="space-y-2">
                                            @foreach($administrations as $admin)
                                                <div class="flex items-center justify-between text-xs">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                                            {{ $admin->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                                            {{ $admin->status === 'missed' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}
                                                            {{ $admin->status === 'refused' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}">
                                                            {{ ucfirst($admin->status) }}
                                                        </span>
                                                        <span class="text-gray-600 dark:text-gray-400">
                                                            {{ \Carbon\Carbon::parse($admin->administered_at)->format('g:i A') }}
                                                        </span>
                                                        @if($admin->dosage_given)
                                                            <span class="text-gray-500 dark:text-gray-500">
                                                                • {{ $admin->dosage_given }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="text-gray-500 dark:text-gray-500">
                                                        by {{ $admin->administeredBy->name ?? 'Unknown' }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Action Buttons -->
                                <div class="p-4 bg-white dark:bg-gray-800 rounded-b-lg">
                                    <div class="flex flex-col gap-3">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            @if(count($medicationTimes) > 1)
                                                Multiple doses scheduled
                                            @else
                                                Single dose scheduled
                                            @endif
                                        </div>
                                        <div class="flex flex-wrap gap-4">
                                            @php
                                                $currentTime = now();
                                                $canAdminister = true; // force visible
                                                $nextScheduledTime = null;
                                                $allDosesCompleted = false;
                                                $todayStart = now()->startOfDay();
                                                $todayEnd = now()->endOfDay();
                                                $completedToday = $medication->administrations()
                                                    ->whereBetween('administered_at', [$todayStart, $todayEnd])
                                                    ->where('status', 'completed')
                                                    ->count();
                                                $totalScheduledDoses = count($medicationTimes);
                                                $allDosesCompleted = ($completedToday >= $totalScheduledDoses && $totalScheduledDoses > 0);
                                            @endphp

                                            @if($canAdminister)
                                                <button
                                                    wire:click="quickAdminister({{ $medication->id }}, 'completed')"
                                                    class="inline-flex items-center px-8 py-6 text-xl font-black bg-teal-600 text-white rounded-2xl hover:bg-teal-700 transition-all duration-200 shadow-2xl hover:shadow-3xl border-4 border-teal-800">
                                                    <x-heroicon-o-check class="h-8 w-8 mr-4" />
                                                    COMPLETE
                                                </button>
                                                <button
                                                    wire:click="quickAdminister({{ $medication->id }}, 'missed')"
                                                    class="inline-flex items-center px-8 py-6 text-xl font-black bg-teal-500 text-white rounded-2xl hover:bg-teal-600 transition-all duration-200 shadow-2xl hover:shadow-3xl border-4 border-teal-700">
                                                    <x-heroicon-o-x-mark class="h-8 w-8 mr-4" />
                                                    MISSED
                                                </button>
                                                <button
                                                    wire:click="quickAdminister({{ $medication->id }}, 'refused')"
                                                    class="inline-flex items-center px-8 py-6 text-xl font-black bg-teal-400 text-white rounded-2xl hover:bg-teal-500 transition-all duration-200 shadow-2xl hover:shadow-3xl border-4 border-teal-600">
                                                    <x-heroicon-o-exclamation-triangle class="h-8 w-8 mr-4" />
                                                    REFUSED
                                                </button>
                                            @else
                                                <div class="flex flex-col items-start gap-2">
                                                    <div class="text-lg font-bold text-gray-600 bg-gray-200 px-6 py-4 rounded-xl border-2 border-gray-400">
                                                        @if($allDosesCompleted)
                                                            All doses completed for today
                                                        @elseif($nextScheduledTime)
                                                            Next dose at {{ $nextScheduledTime->format('g:i A') }}
                                                        @else
                                                            No scheduled doses for today
                                                        @endif
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        Administration window: 30 minutes before/after scheduled time
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <x-heroicon-o-calendar-days class="h-16 w-16 text-gray-400 mx-auto mb-4" />
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Medications Scheduled</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            No medications are scheduled for {{ \Carbon\Carbon::parse($this->selectedDate)->format('M d, Y') }}.
                        </p>
                        <a href="{{ route('filament.admin.resources.medications.create') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                            <x-heroicon-o-plus class="h-4 w-4 mr-2" />
                            Add Medication
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Legend -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Calendar Color Legend</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 border-2 border-green-300 dark:border-green-700 rounded-lg flex items-center justify-center">
                        <span class="text-green-800 dark:text-green-300 font-semibold text-xs">✓</span>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">All Completed</div>
                        <div class="text-gray-600 dark:text-gray-400">Green background when all medications are administered</div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/30 border-2 border-orange-300 dark:border-orange-700 rounded-lg flex items-center justify-center">
                        <span class="text-orange-800 dark:text-orange-300 font-semibold text-xs">!</span>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">Partially Completed</div>
                        <div class="text-gray-600 dark:text-gray-400">Orange background when some medications are pending</div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 border-2 border-red-300 dark:border-red-700 rounded-lg flex items-center justify-center">
                        <span class="text-red-800 dark:text-red-300 font-semibold text-xs">✗</span>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900 dark:text-white">None Completed</div>
                        <div class="text-gray-600 dark:text-gray-400">Red background when no medications are administered</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>