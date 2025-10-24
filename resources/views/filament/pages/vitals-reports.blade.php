<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Vitals Reports</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Comprehensive vital signs analytics and detailed reporting</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('filament.admin.pages.vitals-reports') }}?export=1" 
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

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Vitals</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getVitalsStats()['total_vitals'] }}</p>
                    </div>
                    <x-heroicon-o-heart class="h-8 w-8 text-red-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Today's Vitals</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getVitalsStats()['today_vitals'] }}</p>
                    </div>
                    <x-heroicon-o-calendar-days class="h-8 w-8 text-blue-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">This Week</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getVitalsStats()['this_week_vitals'] }}</p>
                    </div>
                    <x-heroicon-o-chart-bar class="h-8 w-8 text-green-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Avg BP</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getVitalsStats()['avg_systolic'] }}/{{ $this->getVitalsStats()['avg_diastolic'] }}</p>
                    </div>
                    <x-heroicon-o-heart class="h-8 w-8 text-purple-500" />
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Avg Pulse</p>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $this->getVitalsStats()['avg_pulse'] }} bpm</p>
                    </div>
                    <x-heroicon-o-heart class="h-6 w-6 text-red-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Avg Temperature</p>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $this->getVitalsStats()['avg_temperature'] }}°F</p>
                    </div>
                    <x-heroicon-o-fire class="h-6 w-6 text-orange-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Daily Average</p>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ round($this->getVitalsStats()['total_vitals'] / 30, 1) }}</p>
                    </div>
                    <x-heroicon-o-chart-bar class="h-6 w-6 text-indigo-500" />
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Vitals Trends -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Vitals Trends (Last 30 Days)</h3>
                <div class="h-64">
                    <canvas id="vitalsTrendsChart"></canvas>
                </div>
            </div>

            <!-- Blood Pressure Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Blood Pressure Distribution</h3>
                <div class="h-64">
                    <canvas id="bloodPressureChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Vitals by Time of Day -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Vitals by Time of Day (Last 30 Days)</h3>
            <div class="h-64">
                <canvas id="vitalsTimeChart"></canvas>
            </div>
        </div>

        <!-- Data Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Residents by Vitals -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Top 10 Residents by Vitals Count</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Resident</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Count</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Avg BP</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($this->getTopResidentsByVitals() as $resident)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $resident['name'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $resident['vitals_count'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $resident['avg_systolic'] }}/{{ $resident['avg_diastolic'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Staff Performance -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Staff Vitals Performance (Last 30 Days)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Staff Member</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Vitals Taken</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($this->getStaffVitalsPerformance() as $staff)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $staff['name'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $staff['vitals_count'] }}</td>
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
            // Vitals Trends Chart
            const vitalsTrendsCtx = document.getElementById('vitalsTrendsChart');
            if (vitalsTrendsCtx) {
                const trendsData = @json($this->getVitalsTrendsData());
                new Chart(vitalsTrendsCtx, {
                    type: 'line',
                    data: {
                        labels: trendsData.labels,
                        datasets: [
                            {
                                label: 'Vitals Count',
                                data: trendsData.counts,
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.3,
                                fill: true,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Avg Systolic',
                                data: trendsData.systolic,
                                borderColor: '#EF4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                tension: 0.3,
                                yAxisID: 'y1'
                            },
                            {
                                label: 'Avg Diastolic',
                                data: trendsData.diastolic,
                                borderColor: '#F59E0B',
                                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                                tension: 0.3,
                                yAxisID: 'y1'
                            }
                        ]
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
                                type: 'linear',
                                display: true,
                                position: 'left',
                                ticks: {
                                    color: 'rgb(156 163 175)',
                                },
                                grid: {
                                    color: 'rgba(107, 114, 128, 0.2)',
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                ticks: {
                                    color: 'rgb(156 163 175)',
                                },
                                grid: {
                                    drawOnChartArea: false,
                                }
                            }
                        }
                    }
                });
            }

            // Blood Pressure Chart
            const bloodPressureCtx = document.getElementById('bloodPressureChart');
            if (bloodPressureCtx) {
                const bpData = @json($this->getBloodPressureDistribution());
                new Chart(bloodPressureCtx, {
                    type: 'doughnut',
                    data: {
                        labels: bpData.labels,
                        datasets: [{
                            data: bpData.data,
                            backgroundColor: bpData.colors,
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

            // Vitals by Time Chart
            const vitalsTimeCtx = document.getElementById('vitalsTimeChart');
            if (vitalsTimeCtx) {
                const timeData = @json($this->getVitalsByTimeOfDay());
                new Chart(vitalsTimeCtx, {
                    type: 'bar',
                    data: {
                        labels: timeData.labels,
                        datasets: [
                            {
                                label: 'Vitals Count',
                                data: timeData.counts,
                                backgroundColor: '#3B82F6',
                                borderColor: '#1D4ED8',
                                borderWidth: 1,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Avg Systolic',
                                data: timeData.systolic,
                                backgroundColor: '#EF4444',
                                borderColor: '#DC2626',
                                borderWidth: 1,
                                yAxisID: 'y1'
                            }
                        ]
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
                                type: 'linear',
                                display: true,
                                position: 'left',
                                ticks: {
                                    color: 'rgb(156 163 175)',
                                },
                                grid: {
                                    color: 'rgba(107, 114, 128, 0.2)',
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                ticks: {
                                    color: 'rgb(156 163 175)',
                                },
                                grid: {
                                    drawOnChartArea: false,
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-filament-panels::page>
