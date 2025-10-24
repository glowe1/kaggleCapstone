<style>
/* Kuban Card Styles */
.kuban-card {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border: 1px solid #e5e7eb;
    transition: box-shadow 0.2s;
}

.kuban-card:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.kuban-card-header {
    background: linear-gradient(to right, #0D9488, #0B786E);
    border-radius: 0.5rem 0.5rem 0 0;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.kuban-card-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.kuban-avatar {
    width: 2.5rem;
    height: 2.5rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.kuban-card-title-content {
    display: flex;
    flex-direction: column;
}

.kuban-card-title-text {
    color: white;
    font-weight: bold;
    font-size: 1.25rem;
    margin: 0;
}

.kuban-card-subtitle {
    color: #dbeafe;
    font-size: 0.875rem;
    margin: 0;
}

.kuban-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.kuban-badge-primary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.kuban-card-body {
    padding: 1rem;
}

.kuban-info-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.kuban-info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.kuban-info-label {
    color: #4b5563;
    font-weight: 500;
}

.kuban-info-value {
    color: #111827;
    font-weight: bold;
}

.kuban-info-value-primary {
    color: #0D9488;
    font-weight: bold;
}

.kuban-divider {
    border-top: 1px solid #e5e7eb;
    padding-top: 0.75rem;
}

.kuban-card-footer {
    background: #f9fafb;
    border-radius: 0 0 0.5rem 0.5rem;
    padding: 1rem;
}

.kuban-card-footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.kuban-card-meta {
    font-size: 0.875rem;
    color: #6b7280;
}

.kuban-button {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    border: 1px solid transparent;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 0.375rem;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
}

.kuban-button:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(13, 148, 136, 0.5);
}

.kuban-button-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.kuban-button-full {
    width: 100%;
    justify-content: center;
    padding: 0.75rem 1rem;
    font-size: 1rem;
}

.kuban-button-primary {
    color: white;
    background: #0D9488;
}

.kuban-button-primary:hover {
    background: #0B786E;
}

.kuban-button-success {
    color: white;
    background: #059669;
}

.kuban-button-success:hover {
    background: #047857;
}
</style>

<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-teal-50 to-emerald-50 rounded-xl p-6 border border-teal-100">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <svg class="w-8 h-8 inline-block mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Appointments
                </h1>
                <p class="text-gray-600 text-lg">Manage and track resident appointments</p>
            </div>
            <div class="flex space-x-3">
                <button wire:click="loadData" class="flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh
                </button>
                <a href="{{ route('filament.admin.resources.appointments.create') }}" class="flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Appointment
                </a>
            </div>
        </div>
    </div>

    <!-- Appointments Grid - 3 cards per row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($this->getUpcomingAppointments() as $appointment)
            <div class="kuban-card">
                <!-- Card Header -->
                <div class="kuban-card-header">
                    <div class="kuban-card-title">
                        <div class="kuban-avatar">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="kuban-card-title-content">
                            <h3 class="kuban-card-title-text">{{ $appointment->resident->name ?? 'Unknown Resident' }}</h3>
                            <p class="kuban-card-subtitle">{{ $appointment->branch->name ?? 'No Branch' }}</p>
                        </div>
                    </div>
                    <div class="kuban-badge kuban-badge-primary">
                        {{ $appointment->appointmentType->name ?? 'General' }}
                    </div>
                </div>

                <!-- Card Body -->
                <div class="kuban-card-body">
                    <div class="kuban-info-list">
                        <!-- DOB -->
                        <div class="kuban-info-item">
                            <span class="kuban-info-label">DOB:</span>
                            <span class="kuban-info-value">{{ $appointment->resident->date_of_birth ? $appointment->resident->date_of_birth->format('n/j/Y') : 'N/A' }}</span>
                        </div>

                        <!-- Diagnosis -->
                        <div class="kuban-info-item">
                            <span class="kuban-info-label">Diagnosis:</span>
                            <span class="kuban-info-value">{{ $appointment->resident->diagnosis ?: '-' }}</span>
                        </div>

                        <!-- Physician -->
                        <div class="kuban-info-item">
                            <span class="kuban-info-label">Physician:</span>
                            <span class="kuban-info-value">{{ $appointment->resident->physician_name ?: 'N/A' }}</span>
                        </div>

                        <!-- Appointment Details -->
                        <div class="kuban-divider"></div>
                        <div class="kuban-info-item">
                            <span class="kuban-info-label">Appointment:</span>
                            <span class="kuban-info-value kuban-info-value-primary">{{ $appointment->appointment_date->format('M j, Y') }}</span>
                        </div>
                        <div class="kuban-info-item">
                            <span class="kuban-info-label">Time:</span>
                            <span class="kuban-info-value kuban-info-value-primary">{{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') : 'TBD' }}</span>
                        </div>
                        @if($appointment->healthcareProvider)
                        <div class="kuban-info-item">
                            <span class="kuban-info-label">Provider:</span>
                            <span class="kuban-info-value kuban-info-value-primary">{{ $appointment->healthcareProvider->name }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="kuban-card-footer">
                    <div class="kuban-card-footer-content">
                        <div class="kuban-card-meta">
                            {{ $appointment->createdBy->first_name ?? 'System' }}
                        </div>
                    </div>
                    <!-- Appointments Button -->
                    <a href="{{ route('filament.admin.pages.resident-appointments', ['resident_id' => $appointment->resident->id]) }}" 
                       class="kuban-button kuban-button-full kuban-button-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Appointments
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No appointments</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new appointment.</p>
                    <div class="mt-6">
                        <a href="{{ route('filament.admin.resources.appointments.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Appointment
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
