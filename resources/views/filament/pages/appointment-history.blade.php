<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Appointment History</h1>
        <p class="text-gray-600">Filter and view appointment history for all residents</p>
    </div>

    <!-- Table with Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        {{ $this->table }}
    </div>
</div>
