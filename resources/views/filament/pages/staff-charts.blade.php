<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Staff Analytics</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Comprehensive insights about staff performance, workload distribution, and team productivity</p>
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
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Staff</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getStaffStats()['total_staff'] }}</p>
                    </div>
                    <x-heroicon-o-user-group class="h-8 w-8 text-indigo-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Caregivers</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getStaffStats()['total_caregivers'] }}</p>
                    </div>
                    <x-heroicon-o-user class="h-8 w-8 text-blue-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Active Assignments</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getStaffStats()['active_assignments'] }}</p>
                    </div>
                    <x-heroicon-o-link class="h-8 w-8 text-green-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pending Leave</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getStaffStats()['pending_leave_requests'] }}</p>
                    </div>
                    <x-heroicon-o-clock class="h-8 w-8 text-orange-500" />
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Staff Performance -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Top 5 Staff Performance</h3>
                <div class="h-64">
                    <canvas id="staffPerformanceChart"></canvas>
                </div>
            </div>

            <!-- Staff Workload -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Top 5 Staff by Resident Load</h3>
                <div class="h-64">
                    <canvas id="staffWorkloadChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Additional Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Leave Request Trends -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Leave Request Trends (Last 30 Days)</h3>
                <div class="h-64">
                    <canvas id="leaveRequestTrendsChart"></canvas>
                </div>
            </div>

            <!-- Staff Role Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Staff Role Distribution</h3>
                <div class="h-64">
                    <canvas id="staffRoleChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            // Staff Performance Chart
            const staffPerformanceCtx = document.getElementById('staffPerformanceChart');
            if (staffPerformanceCtx) {
                const performanceData = @json($this->getStaffPerformanceData());
                new Chart(staffPerformanceCtx, {
                    type: 'bar',
                    data: {
                        labels: performanceData.labels,
                        datasets: performanceData.datasets
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

            // Staff Workload Chart
            const staffWorkloadCtx = document.getElementById('staffWorkloadChart');
            if (staffWorkloadCtx) {
                const workloadData = @json($this->getStaffWorkloadData());
                new Chart(staffWorkloadCtx, {
                    type: 'bar',
                    data: {
                        labels: workloadData.labels,
                        datasets: [{
                            label: 'Residents Assigned',
                            data: workloadData.data,
                            backgroundColor: workloadData.colors,
                            borderColor: workloadData.colors,
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

            // Leave Request Trends Chart
            const leaveRequestTrendsCtx = document.getElementById('leaveRequestTrendsChart');
            if (leaveRequestTrendsCtx) {
                const trendsData = @json($this->getLeaveRequestTrends());
                new Chart(leaveRequestTrendsCtx, {
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

            // Staff Role Chart
            const staffRoleCtx = document.getElementById('staffRoleChart');
            if (staffRoleCtx) {
                const roleData = @json($this->getStaffRoleDistribution());
                new Chart(staffRoleCtx, {
                    type: 'doughnut',
                    data: {
                        labels: roleData.labels,
                        datasets: [{
                            data: roleData.data,
                            backgroundColor: roleData.colors,
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
