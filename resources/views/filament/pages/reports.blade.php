<x-filament-panels::page>
    <div class="space-y-6">

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Resident Health Status Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Resident Health Status</h3>
                <div class="h-64">
                    <canvas id="residentHealthChart"></canvas>
                </div>
            </div>

            <!-- Staff Performance Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Staff Performance</h3>
                <div class="h-64">
                    <canvas id="staffPerformanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Export Actions with Teal Color Scheme -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                <x-heroicon-o-arrow-down-tray class="w-5 h-5 mr-2 text-teal-600" />
                Export Reports
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button wire:click="exportResidentReport" 
                   class="flex items-center gap-3 p-4 border-2 border-teal-200 dark:border-teal-700 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-colors group">
                    <div class="p-2 bg-teal-100 dark:bg-teal-900/30 rounded-lg group-hover:bg-teal-200 dark:group-hover:bg-teal-800/40 transition-colors">
                        <x-heroicon-o-users class="h-5 w-5 text-teal-600 dark:text-teal-400" />
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Resident Report</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Export resident data</p>
                    </div>
                </button>

                <button wire:click="exportStaffReport" 
                   class="flex items-center gap-3 p-4 border-2 border-teal-200 dark:border-teal-700 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-colors group">
                    <div class="p-2 bg-teal-100 dark:bg-teal-900/30 rounded-lg group-hover:bg-teal-200 dark:group-hover:bg-teal-800/40 transition-colors">
                        <x-heroicon-o-user class="h-5 w-5 text-teal-600 dark:text-teal-400" />
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Staff Report</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Export staff data</p>
                    </div>
                </button>

                <button wire:click="exportFinancialReport" 
                   class="flex items-center gap-3 p-4 border-2 border-teal-200 dark:border-teal-700 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-colors group">
                    <div class="p-2 bg-teal-100 dark:bg-teal-900/30 rounded-lg group-hover:bg-teal-200 dark:group-hover:bg-teal-800/40 transition-colors">
                        <x-heroicon-o-currency-dollar class="h-5 w-5 text-teal-600 dark:text-teal-400" />
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Financial Report</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Export financial data</p>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Resident Health Status Chart
            const residentCtx = document.getElementById('residentHealthChart');
            if (residentCtx) {
                const residentData = @json($this->getResidentCareData());
                
                new Chart(residentCtx, {
                    type: 'doughnut',
                    data: {
                        labels: residentData.labels,
                        datasets: [{
                            data: residentData.data,
                            backgroundColor: residentData.colors,
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#ffffff' : '#374151'
                                }
                            }
                        }
                    }
                });
            }

            // Staff Performance Chart
            const staffCtx = document.getElementById('staffPerformanceChart');
            if (staffCtx) {
                const staffData = @json($this->getStaffPerformanceData());
                
                const labels = staffData.map(staff => staff.name);
                const vitalsData = staffData.map(staff => staff.vitals_recorded);
                const assessmentsData = staffData.map(staff => staff.assessments_completed);
                
                new Chart(staffCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Vitals Recorded',
                                data: vitalsData,
                                backgroundColor: '#3B82F6',
                                borderColor: '#1D4ED8',
                                borderWidth: 2
                            },
                            {
                                label: 'Assessments Completed',
                                data: assessmentsData,
                                backgroundColor: '#10B981',
                                borderColor: '#059669',
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#ffffff' : '#374151'
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#ffffff' : '#374151'
                                },
                                grid: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#374151' : '#e5e7eb'
                                }
                            },
                            y: {
                                ticks: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#ffffff' : '#374151'
                                },
                                grid: {
                                    color: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#374151' : '#e5e7eb'
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-filament-panels::page>