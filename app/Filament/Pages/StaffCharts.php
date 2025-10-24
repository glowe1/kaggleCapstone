<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\User;
use App\Models\Assignment;
use App\Models\VitalSign;
use App\Models\Assessment;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StaffCharts extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.staff-charts';
    protected static ?string $title = 'Staff Analytics';
    protected static ?string $navigationLabel = 'Staff Charts';
    protected static ?string $navigationGroup = 'Reports';
    protected static ?int $navigationSort = 6;

    public static function canAccess(): bool
    {
        return Auth::check() && (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('super_admin'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::check() && (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('super_admin'));
    }

    public function getStaffStats(): array
    {
        $totalStaff = User::whereHas('roles', function($q) {
            $q->whereIn('name', ['caregiver', 'administrator', 'super_admin']);
        })->count();
        
        $totalCaregivers = User::whereHas('roles', function($q) {
            $q->where('name', 'caregiver');
        })->count();
        
        $activeAssignments = Assignment::where('is_active', true)->count();
        $pendingLeaveRequests = LeaveRequest::where('status', 'pending')->count();

        return [
            'total_staff' => $totalStaff,
            'total_caregivers' => $totalCaregivers,
            'active_assignments' => $activeAssignments,
            'pending_leave_requests' => $pendingLeaveRequests,
        ];
    }

    public function getStaffPerformanceData(): array
    {
        $staffPerformance = User::whereHas('roles', function($q) {
            $q->where('name', 'caregiver');
        })->withCount(['vitalSigns', 'assessments'])
        ->orderByDesc('vital_signs_count')
        ->limit(5)
        ->get();

        $labels = $staffPerformance->pluck('name')->toArray();
        $vitalsData = $staffPerformance->pluck('vital_signs_count')->toArray();
        $assessmentsData = $staffPerformance->pluck('assessments_count')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Vitals Recorded',
                    'data' => $vitalsData,
                    'backgroundColor' => '#3B82F6',
                    'borderColor' => '#1D4ED8',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Assessments Completed',
                    'data' => $assessmentsData,
                    'backgroundColor' => '#10B981',
                    'borderColor' => '#059669',
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    public function getStaffWorkloadData(): array
    {
        $workload = Assignment::selectRaw('users.name as caregiver_name, COUNT(assignments.id) as resident_count')
            ->join('users', 'assignments.caregiver_id', '=', 'users.id')
            ->where('assignments.is_active', true)
            ->groupBy('users.name')
            ->orderByDesc('resident_count')
            ->limit(5)
            ->get();

        $labels = $workload->pluck('caregiver_name')->toArray();
        $data = $workload->pluck('resident_count')->toArray();
        $colors = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'];

        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => $colors,
        ];
    }

    public function getLeaveRequestTrends(): array
    {
        $trends = LeaveRequest::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $trends->pluck('date')->map(fn($date) => Carbon::parse($date)->format('M d'))->toArray();
        $data = $trends->pluck('count')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Leave Requests',
                    'data' => $data,
                    'borderColor' => '#F59E0B',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'tension' => 0.3,
                    'fill' => true,
                ],
            ],
        ];
    }

    public function getStaffRoleDistribution(): array
    {
        $roles = User::selectRaw('roles.name as role_name, COUNT(users.id) as user_count')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->whereIn('roles.name', ['caregiver', 'administrator', 'super_admin'])
            ->groupBy('roles.name')
            ->pluck('user_count', 'role_name');

        $labels = $roles->keys()->toArray();
        $data = $roles->values()->toArray();
        $colors = ['#3B82F6', '#10B981', '#8B5CF6']; // Blue, Green, Purple

        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => $colors,
        ];
    }
}
