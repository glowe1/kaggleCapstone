<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Vital Signs Analytics</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Comprehensive analysis of vital signs data</p>
            </div>
            <a href="{{ route('filament.admin.pages.chart-reports') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <x-heroicon-o-arrow-left class="h-4 w-4" />
                Back to Reports
            </a>
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
                    <x-heroicon-o-calendar-days class="h-8 w-8 text-green-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">This Week</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getVitalsStats()['week_vitals'] }}</p>
                    </div>
                    <x-heroicon-o-clock class="h-8 w-8 text-blue-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">This Month</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getVitalsStats()['month_vitals'] }}</p>
                    </div>
                    <x-heroicon-o-chart-bar class="h-8 w-8 text-purple-500" />
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Vitals Trends -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Vitals Trends (Last 7 Days)</h3>
                <div class="h-64">
                    <canvas id="vitalsTrendsChart"></canvas>
                </div>
            </div>

            <!-- Blood Pressure Trends -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Blood Pressure Trends</h3>
                <div class="h-64">
                    <canvas id="bloodPressureChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Additional Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pulse Trends -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Pulse Rate Trends</h3>
                <div class="h-64">
                    <canvas id="pulseChart"></canvas>
                </div>
            </div>

            <!-- Vitals by Time of Day -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Vitals by Time of Day</h3>
                <div class="h-64">
                    <canvas id="timeOfDayChart"></canvas>
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
                const trendsData = @json($this->getVitalsTrends());
                new Chart(vitalsTrendsCtx, {
                    type: 'line',
                    data: {
                        labels: trendsData.map(item => item.date),
                        datasets: [{
                            label: 'Vitals Recorded',
                            data: trendsData.map(item => item.count),
                            borderColor: '#EF4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
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

            // Blood Pressure Chart
            const bloodPressureCtx = document.getElementById('bloodPressureChart');
            if (bloodPressureCtx) {
                const bpData = @json($this->getBloodPressureData());
                new Chart(bloodPressureCtx, {
                    type: 'line',
                    data: {
                        labels: bpData.labels,
                        datasets: [
                            {
                                label: 'Systolic',
                                data: bpData.systolic,
                                borderColor: '#EF4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                tension: 0.3,
                                fill: false,
                            },
                            {
                                label: 'Diastolic',
                                data: bpData.diastolic,
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.3,
                                fill: false,
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

            // Pulse Chart
            const pulseCtx = document.getElementById('pulseChart');
            if (pulseCtx) {
                const pulseData = @json($this->getPulseData());
                new Chart(pulseCtx, {
                    type: 'line',
                    data: {
                        labels: pulseData.labels,
                        datasets: [{
                            label: 'Pulse Rate',
                            data: pulseData.pulse,
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
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

            // Time of Day Chart
            const timeOfDayCtx = document.getElementById('timeOfDayChart');
            if (timeOfDayCtx) {
                const timeData = @json($this->getVitalsByTimeOfDay());
                new Chart(timeOfDayCtx, {
                    type: 'doughnut',
                    data: {
                        labels: timeData.labels,
                        datasets: [{
                            data: timeData.data,
                            backgroundColor: timeData.colors,
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
        });
    </script>
</x-filament-panels::page>
