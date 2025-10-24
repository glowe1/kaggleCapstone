<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center">
                <x-heroicon-o-currency-dollar class="w-5 h-5 mr-2 text-primary-600" />
                Financial Summary
            </div>
        </x-slot>
        
        <x-slot name="description">
            Monthly financial overview
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Monthly Revenue</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">${{ number_format($this->getViewData()['monthly_revenue']) }}</p>
                <div class="mt-2">
                    <x-filament::badge color="success" size="sm">Revenue</x-filament::badge>
                </div>
            </div>
            
            <div class="text-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Monthly Expenses</p>
                <p class="text-2xl font-bold text-red-600 dark:text-red-400">${{ number_format($this->getViewData()['monthly_expenses']) }}</p>
                <div class="mt-2">
                    <x-filament::badge color="danger" size="sm">Expenses</x-filament::badge>
                </div>
            </div>
            
            <div class="text-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Net Profit</p>
                <p class="text-2xl font-bold text-teal-600 dark:text-teal-400">${{ number_format($this->getViewData()['net_profit']) }}</p>
                <div class="mt-2">
                    <x-filament::badge color="primary" size="sm">Profit</x-filament::badge>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
