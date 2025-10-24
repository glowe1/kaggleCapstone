<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Resident Analytics</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Comprehensive insights about your residents</p>
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
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Residents</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getResidentStats()['total_residents'] }}</p>
                    </div>
                    <x-heroicon-o-users class="h-8 w-8 text-blue-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">New This Month</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getResidentStats()['recent_residents'] }}</p>
                    </div>
                    <x-heroicon-o-user-plus class="h-8 w-8 text-green-500" />
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Residents by Branch -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Residents by Branch</h3>
                <div class="h-64">
                    <canvas id="residentsByBranchChart"></canvas>
                </div>
            </div>

            <!-- Age Group Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Age Group Distribution</h3>
                <div class="h-64">
                    <canvas id="ageGroupChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Health Status Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Health Status Distribution</h3>
            <div class="h-64">
                <canvas id="healthStatusChart"></canvas>
            </div>
        </div>

        <!-- Resident Trends -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Resident Registration Trends (Last 30 Days)</h3>
            <div class="h-64">
                <canvas id="residentTrendsChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            // Residents by Branch Chart
            const residentsByBranchCtx = document.getElementById('residentsByBranchChart');
            if (residentsByBranchCtx) {
                const branchData = @json($this->getResidentStats()['residents_by_branch']);
                new Chart(residentsByBranchCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(branchData),
                        datasets: [{
                            label: 'Residents',
                            data: Object.values(branchData),
                            backgroundColor: '#3B82F6',
                            borderColor: '#1D4ED8',
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

            // Age Group Chart
            const ageGroupCtx = document.getElementById('ageGroupChart');
            if (ageGroupCtx) {
                const ageData = @json($this->getResidentStats()['residents_by_age']);
                new Chart(ageGroupCtx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(ageData),
                        datasets: [{
                            data: Object.values(ageData),
                            backgroundColor: ['#EF4444', '#F59E0B', '#3B82F6', '#8B5CF6', '#10B981', '#6B7280'],
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

            // Health Status Chart
            const healthStatusCtx = document.getElementById('healthStatusChart');
            if (healthStatusCtx) {
                const healthData = @json($this->getHealthStatusData());
                new Chart(healthStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: healthData.labels,
                        datasets: [{
                            data: healthData.data,
                            backgroundColor: healthData.colors,
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

            // Resident Trends Chart
            const residentTrendsCtx = document.getElementById('residentTrendsChart');
            if (residentTrendsCtx) {
                const trendsData = @json($this->getResidentTrends());
                new Chart(residentTrendsCtx, {
                    type: 'line',
                    data: {
                        labels: trendsData.map(item => item.date),
                        datasets: [{
                            label: 'New Residents',
                            data: trendsData.map(item => item.count),
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
        });
    </script>
</x-filament-panels::page>
