<x-filament-widgets::widget>
    <div class="p-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Today's Tasks</h3>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Your schedule and pending tasks for today</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Appointments -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border-2 border-blue-500 dark:border-blue-400">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-4 bg-blue-100 dark:bg-blue-900/30 rounded-2xl">
                            <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white">Appointments</h4>
                            <p class="text-gray-600 dark:text-gray-400">{{ count($this->getTasks()['appointments']) }} scheduled</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        @forelse($this->getTasks()['appointments'] as $appointment)
                            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $appointment['resident_name'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $appointment['description'] }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $appointment['time'] }}</p>
                                        <span class="text-xs px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full">
                                            {{ $appointment['status'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center">No appointments today</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Pending Assessments -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border-2 border-green-500 dark:border-green-400">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-4 bg-green-100 dark:bg-green-900/30 rounded-2xl">
                            <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white">Assessments</h4>
                            <p class="text-gray-600 dark:text-gray-400">{{ count($this->getTasks()['assessments']) }} pending</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        @forelse($this->getTasks()['assessments'] as $assessment)
                            <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-700">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $assessment['resident_name'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $assessment['description'] }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-green-600 dark:text-green-400">{{ $assessment['time'] }}</p>
                                        <span class="text-xs px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full">
                                            {{ $assessment['status'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center">No pending assessments</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Vitals Needed -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border-2 border-blue-500 dark:border-blue-400">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-4 bg-blue-100 dark:bg-blue-900/30 rounded-2xl">
                            <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white">Vitals Needed</h4>
                            <p class="text-gray-600 dark:text-gray-400">{{ count($this->getTasks()['vitals_needed']) }} residents</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        @forelse($this->getTasks()['vitals_needed'] as $vital)
                            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $vital['resident_name'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $vital['description'] }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $vital['time'] }}</p>
                                        <span class="text-xs px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full">
                                            {{ $vital['status'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center">All vitals recorded</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
