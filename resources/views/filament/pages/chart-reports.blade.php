<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Chart Reports</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Visual analytics and insights for your care facility</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('filament.admin.pages.vitals-reports') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-red-600 rounded-lg shadow-lg hover:bg-red-700 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 border-2 border-red-500 ring-2 ring-red-200 hover:ring-red-300">
                    <x-heroicon-o-heart class="h-5 w-5 text-white" />
                    <span class="text-white font-bold">Vitals Reports</span>
                </a>
                <a href="{{ route('filament.admin.pages.medication-reports') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-white bg-teal-600 rounded-lg shadow-lg hover:bg-teal-700 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 border-2 border-teal-500 ring-2 ring-teal-200 hover:ring-teal-300">
                    <x-heroicon-o-cube class="h-5 w-5 text-white" />
                    <span class="text-white font-bold">Medication Reports</span>
                </a>
            </div>
        </div>

        <!-- Chart Reports Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Residents Chart Report -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <x-heroicon-o-users class="h-6 w-6 text-teal-500" />
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Residents Analytics</h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Comprehensive charts and insights about resident demographics, health status, and care patterns.</p>
                <a href="{{ route('filament.admin.pages.resident-charts') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600 text-white font-bold text-base rounded-lg shadow-lg hover:bg-teal-700 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 border-2 border-teal-500 ring-2 ring-teal-200 hover:ring-teal-300">
                    <x-heroicon-o-chart-bar class="h-5 w-5 text-white" />
                    <span class="text-white font-bold">View Charts</span>
                </a>
            </div>

            <!-- Vitals Chart Report -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <x-heroicon-o-heart class="h-6 w-6 text-red-500" />
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Vital Signs Analytics</h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Detailed analysis of vital signs trends, health monitoring patterns, and medical insights.</p>
                <a href="{{ route('filament.admin.pages.vitals-charts') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 text-white font-bold text-base rounded-lg shadow-lg hover:bg-red-700 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 border-2 border-red-500 ring-2 ring-red-200 hover:ring-red-300">
                    <x-heroicon-o-chart-bar class="h-5 w-5 text-white" />
                    <span class="text-white font-bold">View Charts</span>
                </a>
            </div>

            <!-- Assessments Chart Report -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <x-heroicon-o-document-text class="h-6 w-6 text-yellow-500" />
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Assessments Analytics</h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Assessment completion rates, progress tracking, and care evaluation insights.</p>
                <a href="{{ route('filament.admin.pages.assessments-charts') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-yellow-600 text-white font-bold text-base rounded-lg shadow-lg hover:bg-yellow-700 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 border-2 border-yellow-500 ring-2 ring-yellow-200 hover:ring-yellow-300">
                    <x-heroicon-o-chart-bar class="h-5 w-5 text-white" />
                    <span class="text-white font-bold">View Charts</span>
                </a>
            </div>

            <!-- Appointments Chart Report -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <x-heroicon-o-calendar-days class="h-6 w-6 text-green-500" />
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Appointments Analytics</h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Appointment scheduling patterns, healthcare provider utilization, and scheduling insights.</p>
                <a href="{{ route('filament.admin.pages.appointments-charts') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white font-bold text-base rounded-lg shadow-lg hover:bg-green-700 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 border-2 border-green-500 ring-2 ring-green-200 hover:ring-green-300">
                    <x-heroicon-o-chart-bar class="h-5 w-5 text-white" />
                    <span class="text-white font-bold">View Charts</span>
                </a>
            </div>

            <!-- Sleep Chart Report -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <x-heroicon-o-moon class="h-6 w-6 text-purple-500" />
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sleep Analytics</h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Sleep pattern analysis, rest quality metrics, and sleep health insights.</p>
                <a href="{{ route('filament.admin.pages.sleep-charts') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 text-white font-bold text-base rounded-lg shadow-lg hover:bg-purple-700 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 border-2 border-purple-500 ring-2 ring-purple-200 hover:ring-purple-300">
                    <x-heroicon-o-chart-bar class="h-5 w-5 text-white" />
                    <span class="text-white font-bold">View Charts</span>
                </a>
            </div>

            <!-- Staff Chart Report -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <x-heroicon-o-user-group class="h-6 w-6 text-indigo-500" />
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Staff Analytics</h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Staff performance metrics, workload distribution, and team productivity insights.</p>
                <a href="{{ route('filament.admin.pages.staff-charts') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-bold text-base rounded-lg shadow-lg hover:bg-indigo-700 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 border-2 border-indigo-500 ring-2 ring-indigo-200 hover:ring-indigo-300">
                    <x-heroicon-o-chart-bar class="h-5 w-5 text-white" />
                    <span class="text-white font-bold">View Charts</span>
                </a>
            </div>
        </div>
    </div>
</x-filament-panels::page>
