<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Appointment;
use App\Models\Resident;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentsCharts extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.appointments-charts';
    protected static ?string $title = 'Appointments Analytics';
    protected static ?string $navigationLabel = 'Appointments Charts';
    protected static ?string $navigationGroup = 'Reports';
    protected static ?int $navigationSort = 4;

    public static function canAccess(): bool
    {
        return Auth::check() && (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('super_admin'));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::check() && (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('super_admin'));
    }

    public function getAppointmentStats(): array
    {
        $totalAppointments = Appointment::count();
        $upcomingAppointments = Appointment::where('appointment_date', '>=', Carbon::today())->count();
        $completedAppointments = Appointment::where('status', 'completed')->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        return [
            'total_appointments' => $totalAppointments,
            'upcoming_appointments' => $upcomingAppointments,
            'completed_appointments' => $completedAppointments,
            'pending_appointments' => $pendingAppointments,
        ];
    }

    public function getAppointmentTrendsData(): array
    {
        $trends = Appointment::selectRaw('DATE(appointment_date) as date, COUNT(*) as count')
            ->where('appointment_date', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $trends->pluck('date')->map(fn($date) => Carbon::parse($date)->format('M d'))->toArray();
        $data = $trends->pluck('count')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Appointments',
                    'data' => $data,
                    'borderColor' => '#3B82F6', // blue-500
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.3,
                    'fill' => true,
                ],
            ],
        ];
    }

    public function getAppointmentTypeDistribution(): array
    {
        $types = Appointment::selectRaw('appointment_types.name as type_name, COUNT(*) as count')
            ->join('appointment_types', 'appointments.appointment_type_id', '=', 'appointment_types.id')
            ->groupBy('appointment_types.name')
            ->pluck('count', 'type_name');

        $labels = $types->keys()->toArray();
        $data = $types->values()->toArray();
        $colors = ['#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6', '#6B7280']; // Red, Orange, Green, Blue, Purple, Gray

        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => $colors,
        ];
    }

    public function getCaregiverLoadData(): array
    {
        $caregiverLoad = Appointment::selectRaw('users.name as caregiver_name, COUNT(appointments.id) as appointment_count')
            ->join('residents', 'appointments.resident_id', '=', 'residents.id')
            ->join('assignments', 'residents.id', '=', 'assignments.resident_id')
            ->join('users', 'assignments.caregiver_id', '=', 'users.id')
            ->where('assignments.is_active', true)
            ->groupBy('users.name')
            ->orderByDesc('appointment_count')
            ->limit(5)
            ->get();

        $labels = $caregiverLoad->pluck('caregiver_name')->toArray();
        $data = $caregiverLoad->pluck('appointment_count')->toArray();
        $colors = ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'];

        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => $colors,
        ];
    }
}
