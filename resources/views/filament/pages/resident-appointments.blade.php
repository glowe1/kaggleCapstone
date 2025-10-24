<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <svg class="w-8 h-8 inline-block mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Resident Appointments
                </h1>
                <p class="text-gray-600 text-lg">
                    @if($this->resident)
                        Managing appointments for <strong>{{ $this->resident->name }}</strong>
                    @else
                        Manage and track resident appointments
                    @endif
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('filament.admin.pages.custom-appointments') }}" class="flex items-center px-6 py-3 bg-gray-200 text-black font-bold rounded-lg hover:bg-gray-300 transition-colors shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Appointments
                </a>
            </div>
        </div>
    </div>

    <!-- Add Appointment Form Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Create New Appointment</h2>
        </div>
        <div class="p-6">
            <form wire:submit="submit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Appointment Date -->
                    <div>
                        <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">Appointment Date</label>
                        <input 
                            type="date" 
                            wire:model="data.appointment_date" 
                            id="appointment_date" 
                            name="appointment_date" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            required>
                    </div>

                    <!-- Appointment Time -->
                    <div>
                        <label for="appointment_time" class="block text-sm font-medium text-gray-700 mb-2">Appointment Time</label>
                        <input 
                            type="time" 
                            wire:model="data.appointment_time" 
                            id="appointment_time" 
                            name="appointment_time" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            required>
                    </div>

                    <!-- Appointment Type -->
                    <div>
                        <label for="appointment_type_id" class="block text-sm font-medium text-gray-700 mb-2">Appointment Type</label>
                        <select 
                            wire:model="data.appointment_type_id" 
                            id="appointment_type_id" 
                            name="appointment_type_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            required>
                            <option value="">Select Type</option>
                            <option value="1">Primary Care Provider</option>
                            <option value="2">Specialist</option>
                            <option value="3">Counsellor</option>
                            <option value="4">Clinician</option>
                            <option value="5">Other</option>
                        </select>
                    </div>

                    <!-- Healthcare Provider -->
                    <div>
                        <label for="healthcare_provider_id" class="block text-sm font-medium text-gray-700 mb-2">Healthcare Provider</label>
                        <select 
                            wire:model="data.healthcare_provider_id" 
                            id="healthcare_provider_id" 
                            name="healthcare_provider_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Provider</option>
                            <option value="1">Dr. Michael Chen</option>
                            <option value="2">Dr. Sarah Martinez</option>
                            <option value="3">Dr. James Wilson</option>
                            <option value="4">Dr. Lisa Rodriguez</option>
                        </select>
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input 
                            type="text" 
                            wire:model="data.location" 
                            id="location" 
                            name="location" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="Enter location">
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select 
                            wire:model="data.status" 
                            id="status" 
                            name="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            required>
                            <option value="scheduled">Scheduled</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea 
                        wire:model="data.description" 
                        id="description" 
                        name="description" 
                        rows="3" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                        placeholder="Enter appointment description...">
                    </textarea>
                </div>

                
                <div class="flex justify-end mt-8">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gray-200 text-black font-bold rounded-lg hover:bg-gray-300 transition-colors shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        CREATE APPOINTMENT
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Appointment History Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Appointment History</h2>
        </div>
        <div class="p-6">
            {{ $this->table }}
        </div>
    </div>
</div>
