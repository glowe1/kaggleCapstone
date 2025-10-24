<x-filament-panels::page>
    @if($this->getAssessment())
        <div class="space-y-6">
            <!-- Assessment Header -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $this->getAssessment()->resident->name ?? 'Unknown Resident' }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ ucfirst($this->getAssessment()->assessment_type) }} Assessment
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-500">
                            Branch: {{ $this->getAssessment()->branch->name ?? 'Unknown Branch' }}
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500 dark:text-gray-500">Progress</div>
                        <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                            {{ $this->getCompletionPercentage() }}%
                        </div>
                        <div class="w-32 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-2">
                            <div class="bg-primary-600 h-2 rounded-full" 
                                 style="width: {{ $this->getCompletionPercentage() }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assessment Form -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="p-6">
                    {{ $this->form }}
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4">
                {{ $this->saveAction }}
                {{ $this->submitAction }}
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8">
            <div class="text-center">
                <div class="mx-auto h-16 w-16 text-gray-300 dark:text-gray-600 mb-4">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Assessment Selected</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">
                    Please select an assessment from the assessments list to complete.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="/admin/assessments" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Assessments
                    </a>
                    <a href="/admin/assessment-page" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create New Assessment
                    </a>
                </div>
            </div>
        </div>
    @endif
</x-filament-panels::page>