<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Sleep Analytics</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Comprehensive insights about sleep patterns and rest quality metrics</p>
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
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Sleep Records</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getSleepStats()['total_sleep_records'] }}</p>
                    </div>
                    <x-heroicon-o-moon class="h-8 w-8 text-purple-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Sleep Patterns</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getSleepStats()['total_sleep_patterns'] }}</p>
                    </div>
                    <x-heroicon-o-chart-bar class="h-8 w-8 text-blue-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">This Week</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getSleepStats()['this_week_sleep_records'] }}</p>
                    </div>
                    <x-heroicon-o-calendar-days class="h-8 w-8 text-green-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Avg Sleep Hours</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getSleepStats()['average_sleep_hours'] }}h</p>
                    </div>
                    <x-heroicon-o-clock class="h-8 w-8 text-orange-500" />
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Sleep Trends -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Sleep Trends (Last 30 Days)</h3>
                <div class="h-64">
                    <canvas id="sleepTrendsChart"></canvas>
                </div>
            </div>

            <!-- Sleep Quality Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Sleep Quality Distribution</h3>
                <div class="h-64">
                    <canvas id="sleepQualityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Additional Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Sleep Hours Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Sleep Hours Distribution</h3>
                <div class="h-64">
                    <canvas id="sleepHoursChart"></canvas>
                </div>
            </div>

            <!-- Top Residents by Sleep Hours -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Top 5 Residents by Average Sleep Hours</h3>
                <div class="h-64">
                    <canvas id="residentSleepChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            // Sleep Trends Chart
            const sleepTrendsCtx = document.getElementById('sleepTrendsChart');
            if (sleepTrendsCtx) {
                const trendsData = @json($this->getSleepTrendsData());
                new Chart(sleepTrendsCtx, {
                    type: 'line',
                    data: {
                        labels: trendsData.labels,
                        datasets: trendsData.datasets
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

            // Sleep Quality Chart
            const sleepQualityCtx = document.getElementById('sleepQualityChart');
            if (sleepQualityCtx) {
                const qualityData = @json($this->getSleepQualityDistribution());
                new Chart(sleepQualityCtx, {
                    type: 'doughnut',
                    data: {
                        labels: qualityData.labels,
                        datasets: [{
                            data: qualityData.data,
                            backgroundColor: qualityData.colors,
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

            // Sleep Hours Chart
            const sleepHoursCtx = document.getElementById('sleepHoursChart');
            if (sleepHoursCtx) {
                const hoursData = @json($this->getSleepHoursDistribution());
                new Chart(sleepHoursCtx, {
                    type: 'doughnut',
                    data: {
                        labels: hoursData.labels,
                        datasets: [{
                            data: hoursData.data,
                            backgroundColor: hoursData.colors,
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

            // Resident Sleep Chart
            const residentSleepCtx = document.getElementById('residentSleepChart');
            if (residentSleepCtx) {
                const residentData = @json($this->getResidentSleepData());
                new Chart(residentSleepCtx, {
                    type: 'bar',
                    data: {
                        labels: residentData.labels,
                        datasets: [{
                            label: 'Average Sleep Hours',
                            data: residentData.data,
                            backgroundColor: residentData.colors,
                            borderColor: residentData.colors,
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
