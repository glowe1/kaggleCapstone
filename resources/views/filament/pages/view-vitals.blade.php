<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Resident Vitals</h1>
                <p class="text-gray-600 mt-1">View and filter vital signs records for all residents</p>
            </div>
            <button wire:click="newVitals" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Create New Vitals
            </button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6">
            {{ $this->table }}
        </div>
    </div>
</div>