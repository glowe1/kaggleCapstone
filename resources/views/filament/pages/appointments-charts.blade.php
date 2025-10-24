<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Appointments Analytics</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Comprehensive insights about appointment scheduling and healthcare provider utilization</p>
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
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Appointments</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getAppointmentStats()['total_appointments'] }}</p>
                    </div>
                    <x-heroicon-o-calendar-days class="h-8 w-8 text-green-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Upcoming</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getAppointmentStats()['upcoming_appointments'] }}</p>
                    </div>
                    <x-heroicon-o-clock class="h-8 w-8 text-blue-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Completed</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getAppointmentStats()['completed_appointments'] }}</p>
                    </div>
                    <x-heroicon-o-check-circle class="h-8 w-8 text-green-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pending</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getAppointmentStats()['pending_appointments'] }}</p>
                    </div>
                    <x-heroicon-o-exclamation-triangle class="h-8 w-8 text-orange-500" />
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Appointment Trends -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Appointment Trends (Last 30 Days)</h3>
                <div class="h-64">
                    <canvas id="appointmentTrendsChart"></canvas>
                </div>
            </div>

            <!-- Appointment Type Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Appointment Type Distribution</h3>
                <div class="h-64">
                    <canvas id="appointmentTypeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Caregiver Load Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Top 5 Caregivers by Appointment Load</h3>
            <div class="h-64">
                <canvas id="caregiverLoadChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            // Appointment Trends Chart
            const appointmentTrendsCtx = document.getElementById('appointmentTrendsChart');
            if (appointmentTrendsCtx) {
                const trendsData = @json($this->getAppointmentTrendsData());
                new Chart(appointmentTrendsCtx, {
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

            // Appointment Type Chart
            const appointmentTypeCtx = document.getElementById('appointmentTypeChart');
            if (appointmentTypeCtx) {
                const typeData = @json($this->getAppointmentTypeDistribution());
                new Chart(appointmentTypeCtx, {
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

            // Caregiver Load Chart
            const caregiverLoadCtx = document.getElementById('caregiverLoadChart');
            if (caregiverLoadCtx) {
                const loadData = @json($this->getCaregiverLoadData());
                new Chart(caregiverLoadCtx, {
                    type: 'bar',
                    data: {
                        labels: loadData.labels,
                        datasets: [{
                            label: 'Appointments',
                            data: loadData.data,
                            backgroundColor: loadData.colors,
                            borderColor: loadData.colors,
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
