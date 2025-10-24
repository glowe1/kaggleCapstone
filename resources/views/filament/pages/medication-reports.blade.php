<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Medication Reports</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Comprehensive medication management analytics and detailed reporting</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('filament.admin.pages.medication-reports') }}?export=1" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <x-heroicon-o-arrow-down class="h-4 w-4" />
                    Export CSV
                </a>
                <a href="{{ route('filament.admin.pages.chart-reports') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <x-heroicon-o-arrow-left class="h-4 w-4" />
                    Back to Charts
                </a>
            </div>
        </div>


        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Medication Trends -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Administration Trends (Last 30 Days)</h3>
                <div class="h-64">
                    <canvas id="medicationTrendsChart"></canvas>
                </div>
            </div>

            <!-- Medication Type Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Medication Type Distribution</h3>
                <div class="h-64">
                    <canvas id="medicationTypeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Additional Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Administration Status -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Administration Status Distribution</h3>
                <div class="h-64">
                    <canvas id="administrationStatusChart"></canvas>
                </div>
            </div>

            <!-- Medications by Time of Day -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Administrations by Time of Day (Last 30 Days)</h3>
                <div class="h-64">
                    <canvas id="medicationsTimeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Data Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Residents by Medications -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Top 10 Residents by Active Medications</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Resident</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Active Medications</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($this->getTopResidentsByMedications() as $resident)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $resident['name'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $resident['medication_count'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Staff Performance -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Staff Medication Performance (Last 30 Days)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Staff Member</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Administrations</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($this->getStaffMedicationPerformance() as $staff)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $staff['name'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $staff['administrations_count'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            // Medication Trends Chart
            const medicationTrendsCtx = document.getElementById('medicationTrendsChart');
            if (medicationTrendsCtx) {
                const trendsData = @json($this->getMedicationTrendsData());
                new Chart(medicationTrendsCtx, {
                    type: 'line',
                    data: {
                        labels: trendsData.labels,
                        datasets: [{
                            label: 'Administrations',
                            data: trendsData.data,
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.3,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'rgb(156 163 175)',
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: 'rgb(156 163 175)',
                                },
                                grid: {
                                    color: 'rgba(107, 114, 128, 0.2)',
                                }
                            },
                            y: {
                                ticks: {
                                    color: 'rgb(156 163 175)',
                                },
                                grid: {
                                    color: 'rgba(107, 114, 128, 0.2)',
                                }
                            }
                        }
                    }
                });
            }

            // Medication Type Chart
            const medicationTypeCtx = document.getElementById('medicationTypeChart');
            if (medicationTypeCtx) {
                const typeData = @json($this->getMedicationTypeDistribution());
                new Chart(medicationTypeCtx, {
                    type: 'doughnut',
                    data: {
                        labels: typeData.labels,
                        datasets: [{
                            data: typeData.data,
                            backgroundColor: typeData.colors,
                            borderColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#374151' : '#ffffff',
                            borderWidth: 2,
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

            // Administration Status Chart
            const administrationStatusCtx = document.getElementById('administrationStatusChart');
            if (administrationStatusCtx) {
                const statusData = @json($this->getAdministrationStatusDistribution());
                new Chart(administrationStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: statusData.labels,
                        datasets: [{
                            data: statusData.data,
                            backgroundColor: statusData.colors,
                            borderColor: window.matchMedia('(prefers-color-scheme: dark)').matches ? '#374151' : '#ffffff',
                            borderWidth: 2,
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

            // Medications by Time Chart
            const medicationsTimeCtx = document.getElementById('medicationsTimeChart');
            if (medicationsTimeCtx) {
                const timeData = @json($this->getMedicationsByTimeOfDay());
                new Chart(medicationsTimeCtx, {
                    type: 'bar',
                    data: {
                        labels: timeData.labels,
                        datasets: [{
                            label: 'Administrations',
                            data: timeData.data,
                            backgroundColor: '#10B981',
                            borderColor: '#059669',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'rgb(156 163 175)',
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: 'rgb(156 163 175)',
                                },
                                grid: {
                                    color: 'rgba(107, 114, 128, 0.2)',
                                }
                            },
                            y: {
                                ticks: {
                                    color: 'rgb(156 163 175)',
                                },
                                grid: {
                                    color: 'rgba(107, 114, 128, 0.2)',
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-filament-panels::page>
