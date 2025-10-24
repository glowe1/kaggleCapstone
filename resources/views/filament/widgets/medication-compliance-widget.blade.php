<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center">
                <x-heroicon-o-chart-pie class="w-5 h-5 mr-2 text-primary-600" />
                Medication Compliance Rate (Last 30 Days)
            </div>
        </x-slot>
        
        <x-slot name="description">
            Track medication adherence and compliance rates
        </x-slot>

        <div class="flex items-center justify-between mb-4">
            <div class="flex-1">
                <div class="text-4xl font-bold text-teal-600 dark:text-teal-400 mb-2">
                    {{ $this->getViewData()['compliance_rate'] }}%
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $this->getViewData()['completed'] }} of {{ $this->getViewData()['total_scheduled'] }} doses completed
                </p>
            </div>
            <div class="ml-6">
                <div class="w-24 h-24 relative">
                    <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="8" fill="none" class="text-gray-200 dark:text-gray-700"></circle>
                        <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="8" fill="none" 
                                stroke-dasharray="{{ 2 * pi() * 40 }}" 
                                stroke-dashoffset="{{ 2 * pi() * 40 * (1 - $this->getViewData()['compliance_rate'] / 100) }}"
                                class="text-teal-600 dark:text-teal-400 transition-all duration-1000 ease-out"
                                stroke-linecap="round"></circle>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-lg font-bold text-teal-600 dark:text-teal-400">{{ $this->getViewData()['compliance_rate'] }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 h-3 rounded-full transition-all duration-1000 ease-out" 
                 style="width: {{ $this->getViewData()['compliance_rate'] }}%"></div>
        </div>

        <div class="mt-4 grid grid-cols-3 gap-4 text-center">
            <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $this->getViewData()['completed'] }}</div>
                <div class="text-sm text-green-600 dark:text-green-400">Completed</div>
            </div>
            <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $this->getViewData()['missed'] }}</div>
                <div class="text-sm text-red-600 dark:text-red-400">Missed</div>
            </div>
            <div class="p-3 bg-teal-50 dark:bg-teal-900/20 rounded-lg">
                <div class="text-2xl font-bold text-teal-600 dark:text-teal-400">{{ $this->getViewData()['total_scheduled'] }}</div>
                <div class="text-sm text-teal-600 dark:text-teal-400">Total</div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
