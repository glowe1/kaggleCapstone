<div class="flex items-center space-x-4">
    <!-- User Profile - Only Avatar -->
    <div class="flex items-center">
        <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
            <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name ?? 'AU', 0, 2) }}</span>
        </div>
    </div>
</div>
