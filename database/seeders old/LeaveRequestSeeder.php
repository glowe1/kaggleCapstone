<?php

namespace Database\Seeders;

use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->info('No users found. Please run user seeders first.');
            return;
        }

        $sampleRequests = [
            [
                'staff_id' => $users->first()->id,
                'start_date' => now()->addDays(7),
                'end_date' => now()->addDays(9),
                'reason' => 'I would like to bring to your attention that, I have medical referral appointment on 10/28/25 at Swedish hospital at 9:30am. I will be grateful to leave on said date at 8:00am in the morning and be back at 11am. I hope my request would meet your kind consideration and approval. Thank you.',
                'status' => 'pending',
            ],
            [
                'staff_id' => $users->skip(1)->first()?->id ?? $users->first()->id,
                'start_date' => now()->addDays(14),
                'end_date' => now()->addDays(16),
                'reason' => 'Family emergency - need to attend to urgent family matter out of state. Will return as soon as possible.',
                'status' => 'approved',
                'approved_by' => $users->first()->id,
                'approved_at' => now()->subDays(2),
            ],
            [
                'staff_id' => $users->skip(2)->first()?->id ?? $users->first()->id,
                'start_date' => now()->addDays(21),
                'end_date' => now()->addDays(28),
                'reason' => 'Annual vacation leave. Planning to visit family and take some time off for rest and relaxation.',
                'status' => 'declined',
                'decline_reason' => 'Unable to approve due to staffing constraints during this period. Please consider alternative dates.',
                'approved_by' => $users->first()->id,
                'approved_at' => now()->subDays(1),
            ],
            [
                'staff_id' => $users->skip(3)->first()?->id ?? $users->first()->id,
                'start_date' => now()->addDays(3),
                'end_date' => now()->addDays(3),
                'reason' => 'Personal appointment - dental checkup and cleaning. Will return to work the same day.',
                'status' => 'pending',
            ],
            [
                'staff_id' => $users->skip(4)->first()?->id ?? $users->first()->id,
                'start_date' => now()->addDays(10),
                'end_date' => now()->addDays(12),
                'reason' => 'Bereavement leave - attending funeral services for immediate family member.',
                'status' => 'approved',
                'approved_by' => $users->first()->id,
                'approved_at' => now()->subHours(6),
            ],
        ];

        foreach ($sampleRequests as $requestData) {
            LeaveRequest::create($requestData);
        }

        $this->command->info('Sample leave requests created successfully.');
    }
}
