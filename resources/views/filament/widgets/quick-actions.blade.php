<x-filament-widgets::widget>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Quick Actions</h3>
                <p class="text-gray-600">Fast access to common tasks</p>
            </div>
        </div>
        
        <!-- Actions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Add Resident -->
            <a href="{{ route('filament.admin.resources.residents.create') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Add Resident</h4>
                        <p class="text-sm text-gray-600">New resident intake</p>
                    </div>
                </div>
            </a>
            
            <!-- Schedule Appointment -->
            <a href="{{ route('filament.admin.resources.appointments.create') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-green-50 to-green-100 border border-green-200 p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Schedule Appointment</h4>
                        <p class="text-sm text-gray-600">Book medical visit</p>
                    </div>
                </div>
            </a>
            
            <!-- Add Medication -->
            <a href="{{ route('filament.admin.resources.medications.create') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Add Medication</h4>
                        <p class="text-sm text-gray-600">New prescription</p>
                    </div>
                </div>
            </a>
            
            <!-- Record Vital Signs -->
            <a href="{{ route('filament.admin.resources.vital-signs.create') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Record Vitals</h4>
                        <p class="text-sm text-gray-600">Health monitoring</p>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Secondary Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Staff Management -->
            <a href="{{ route('filament.admin.resources.users.index') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 p-4 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Staff Management</h4>
                        <p class="text-sm text-gray-600">Manage team members</p>
                    </div>
                </div>
            </a>
            
            <!-- Incident Reports -->
            <a href="{{ route('filament.admin.resources.incidents.create') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-red-50 to-red-100 border border-red-200 p-4 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Incident Report</h4>
                        <p class="text-sm text-gray-600">Document incidents</p>
                    </div>
                </div>
            </a>
            
            <!-- Behavior Tracking -->
            <a href="{{ route('filament.admin.resources.behaviors.create') }}" class="group relative overflow-hidden rounded-xl bg-gradient-to-br from-teal-50 to-teal-100 border border-teal-200 p-4 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">Behavior Tracking</h4>
                        <p class="text-sm text-gray-600">Monitor behaviors</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-filament-widgets::widget>







