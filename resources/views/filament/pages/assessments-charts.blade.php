<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Assessment Analytics</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Comprehensive insights about assessment completion and progress</p>
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
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Assessments</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getAssessmentStats()['total_assessments'] }}</p>
                    </div>
                    <x-heroicon-o-document-text class="h-8 w-8 text-yellow-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Completed</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getAssessmentStats()['completed_assessments'] }}</p>
                    </div>
                    <x-heroicon-o-check-circle class="h-8 w-8 text-green-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pending</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getAssessmentStats()['pending_assessments'] }}</p>
                    </div>
                    <x-heroicon-o-clock class="h-8 w-8 text-orange-500" />
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">This Month</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $this->getAssessmentStats()['this_month_assessments'] }}</p>
                    </div>
                    <x-heroicon-o-calendar-days class="h-8 w-8 text-blue-500" />
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Assessment Completion Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Assessment Completion Distribution</h3>
                <div class="h-64">
                    <canvas id="completionChart"></canvas>
                </div>
            </div>

            <!-- Assessment Trends -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Assessment Trends (Last 30 Days)</h3>
                <div class="h-64">
                    <canvas id="assessmentTrendsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            // Completion Chart
            const completionCtx = document.getElementById('completionChart');
            if (completionCtx) {
                const completionData = @json($this->getCompletionData());
                new Chart(completionCtx, {
                    type: 'doughnut',
                    data: {
                        labels: completionData.labels,
                        datasets: [{
                            data: completionData.data,
                            backgroundColor: completionData.colors,
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

            // Assessment Trends Chart
            const assessmentTrendsCtx = document.getElementById('assessmentTrendsChart');
            if (assessmentTrendsCtx) {
                const trendsData = @json($this->getAssessmentTrends());
                new Chart(assessmentTrendsCtx, {
                    type: 'line',
                    data: {
                        labels: trendsData.map(item => item.date),
                        datasets: [{
                            label: 'New Assessments',
                            data: trendsData.map(item => item.count),
                            borderColor: '#F59E0B',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
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
