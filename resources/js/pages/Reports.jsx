import React from 'react';
import { useNavigate } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import api from '../services/api';
import { 
    BarChart3, 
    Users, 
    Activity, 
    Calendar, 
    Brain,
    History,
    Moon,
    UserCheck,
    Clock,
    ArrowRight
} from 'lucide-react';

export default function Reports() {
    const navigate = useNavigate();

    // Fetch monthly statistics
    const { data: statsData, isLoading } = useQuery({
        queryKey: ['reports-stats-monthly'],
        queryFn: async () => {
            const now = new Date();
            const startOfMonth = new Date(now.getFullYear(), now.getMonth(), 1);
            const endOfMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0, 23, 59, 59);
            const startDateStr = startOfMonth.toISOString().split('T')[0];
            const endDateStr = endOfMonth.toISOString().split('T')[0];
            
            try {
                // Get appointments for the month
                const appointmentsRes = await api.get('/appointments', {
                    params: {
                        per_page: 1000, // Get enough to count
                        date_filter: 'all', // Get all, then filter by date range
                    }
                });
                const appointmentsCount = appointmentsRes.data?.data?.filter(apt => {
                    const aptDate = new Date(apt.appointment_date);
                    return aptDate >= startOfMonth && aptDate <= endOfMonth;
                }).length || 0;
                
                // Get vitals for the month using date filtering
                const vitalsRes = await api.get('/vitals', {
                    params: {
                        per_page: 1000,
                        date_from: startDateStr,
                        date_to: endDateStr,
                    }
                });
                const vitalsCount = vitalsRes.data?.total || vitalsRes.data?.data?.length || 0;
                
                // Get residents (total count, not filtered by month)
                const residentsRes = await api.get('/residents', { params: { per_page: 1 } });
                const residentsCount = residentsRes.data?.total || 0;
                
                // Get assessments for the month (need to filter manually as API may not support date filtering)
                const assessmentsRes = await api.get('/assessments', {
                    params: {
                        per_page: 1000,
                    }
                });
                const assessmentsCount = assessmentsRes.data?.data?.filter(assessment => {
                    const assessDate = new Date(assessment.created_at || assessment.assessment_date || assessment.date);
                    return assessDate >= startOfMonth && assessDate <= endOfMonth;
                }).length || 0;
                
                return {
                    appointments: appointmentsCount,
                    vitals: vitalsCount,
                    residents: residentsCount,
                    assessments: assessmentsCount,
                };
            } catch (error) {
                console.error('Error fetching monthly stats:', error);
                return {
                    appointments: 0,
                    vitals: 0,
                    residents: 0,
                    assessments: 0,
                };
            }
        },
    });

    const chartPages = [
        {
            title: 'Chart Reports',
            description: 'This Month',
            icon: BarChart3,
            link: '/reports/charts',
            value: statsData?.residents || 0,
            gradient: 'from-blue-500 to-blue-600',
            iconBg: 'bg-blue-50',
            iconColor: 'text-blue-600'
        },
        {
            title: 'Resident Charts',
            description: 'This Month',
            icon: Users,
            link: '/reports/resident-charts',
            value: statsData?.residents || 0,
            gradient: 'from-purple-500 to-purple-600',
            iconBg: 'bg-purple-50',
            iconColor: 'text-purple-600'
        },
        {
            title: 'Vitals Charts',
            description: 'This Month',
            icon: Activity,
            link: '/reports/vitals-charts',
            value: statsData?.vitals || 0,
            gradient: 'from-red-500 to-red-600',
            iconBg: 'bg-red-50',
            iconColor: 'text-red-600'
        },
        {
            title: 'Vitals Reports',
            description: 'This Month',
            icon: History,
            link: '/reports/vitals-reports',
            value: statsData?.vitals || 0,
            gradient: 'from-orange-500 to-orange-600',
            iconBg: 'bg-orange-50',
            iconColor: 'text-orange-600'
        },
        {
            title: 'Assessment Charts',
            description: 'This Month',
            icon: Brain,
            link: '/reports/assessment-charts',
            value: statsData?.assessments || 0,
            gradient: 'from-indigo-500 to-indigo-600',
            iconBg: 'bg-indigo-50',
            iconColor: 'text-indigo-600'
        },
        {
            title: 'Appointments Charts',
            description: 'This Month',
            icon: Calendar,
            link: '/reports/appointments-charts',
            value: statsData?.appointments || 0,
            gradient: 'from-green-500 to-green-600',
            iconBg: 'bg-green-50',
            iconColor: 'text-green-600'
        },
        {
            title: 'Vitals History',
            description: 'This Month',
            icon: Clock,
            link: '/reports/vitals-history',
            value: statsData?.vitals || 0,
            gradient: 'from-teal-500 to-teal-600',
            iconBg: 'bg-teal-50',
            iconColor: 'text-teal-600'
        },
        {
            title: 'Sleep Charts',
            description: 'This Month',
            icon: Moon,
            link: '/reports/sleep-charts',
            value: 0,
            gradient: 'from-slate-500 to-slate-600',
            iconBg: 'bg-slate-50',
            iconColor: 'text-slate-600'
        },
        {
            title: 'Staff Charts',
            description: 'This Month',
            icon: UserCheck,
            link: '/reports/staff-charts',
            value: 0,
            gradient: 'from-pink-500 to-pink-600',
            iconBg: 'bg-pink-50',
            iconColor: 'text-pink-600'
        },
    ];

    return (
        <div className="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-50">
            {/* Main Content */}
            <div className="max-w-7xl mx-auto px-4 md:px-6 py-6 md:py-8">
                {/* Page Header */}
                <div className="mb-8">
                    <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 md:p-8">
                        <div className="flex items-center gap-4 mb-4">
                            <div className="p-3 bg-gradient-to-br from-[var(--theme-primary)] to-[var(--theme-primary-hover)] rounded-xl">
                                <BarChart3 className="w-8 h-8 text-white" />
                            </div>
                            <div>
                                <h1 className="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Chart Reports</h1>
                                <p className="text-gray-600 text-lg">Access and view detailed analytics across all report categories</p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Chart Cards Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                    {isLoading ? (
                        <div className="col-span-full">
                            <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                                <div className="inline-block animate-spin rounded-full h-12 w-12 border-4 border-[var(--theme-primary)] border-t-transparent"></div>
                                <p className="mt-6 text-gray-600 text-lg font-medium">Loading statistics...</p>
                            </div>
                        </div>
                    ) : (
                        chartPages.map((page, index) => {
                            const Icon = page.icon;
                            return (
                                <div
                                    key={index}
                                    onClick={() => navigate(page.link)}
                                    className="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden cursor-pointer border border-gray-100 hover:border-transparent active:scale-[0.98]"
                                >
                                    {/* Gradient decoration */}
                                    <div className={`absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r ${page.gradient}`}></div>
                                    
                                    {/* Content */}
                                    <div className="p-6">
                                        <div className="flex items-start justify-between mb-4">
                                            <div className="flex-1 min-w-0">
                                                <p className="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-2 truncate">
                                                    {page.title}
                                                </p>
                                                <div className="flex items-baseline space-x-2 mb-3">
                                                    <p className="text-3xl md:text-4xl font-bold text-gray-900">
                                                        {page.value.toLocaleString()}
                                                    </p>
                                                </div>
                                                {page.description && (
                                                    <p className="text-gray-500 text-sm flex items-center">
                                                        <Clock className="w-4 h-4 mr-1.5" />
                                                        {page.description}
                                                    </p>
                                                )}
                                            </div>
                                            <div className={`${page.iconBg} p-3 rounded-xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 flex-shrink-0 ml-4`}>
                                                <Icon className={`w-7 h-7 ${page.iconColor}`} />
                                            </div>
                                        </div>
                                        
                                        {/* Hover effect */}
                                        <div className="flex items-center text-[var(--theme-primary)] text-sm font-semibold opacity-0 group-hover:opacity-100 transition-all duration-300 mt-4 pt-4 border-t border-gray-100">
                                            <span>View details</span>
                                            <ArrowRight className="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" />
                                        </div>
                                    </div>

                                    {/* Shine effect on hover */}
                                    <div className="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                </div>
                            );
                        })
                    )}
                </div>
            </div>
        </div>
    );
}
