import React from 'react';
import { useNavigate } from 'react-router-dom';
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

    const chartPages = [
        {
            title: 'Chart Reports',
            description: 'Today',
            icon: BarChart3,
            link: '/reports/charts',
            value: 0
        },
        {
            title: 'Resident Charts',
            description: 'Today',
            icon: Users,
            link: '/reports/resident-charts',
            value: 0
        },
        {
            title: 'Vitals Charts',
            description: 'Today',
            icon: Activity,
            link: '/reports/vitals-charts',
            value: 0
        },
        {
            title: 'Vitals Reports',
            description: 'Today',
            icon: History,
            link: '/reports/vitals-reports',
            value: 0
        },
        {
            title: 'Assessment Charts',
            description: 'Today',
            icon: Brain,
            link: '/reports/assessment-charts',
            value: 0
        },
        {
            title: 'Appointments Charts',
            description: 'Today',
            icon: Calendar,
            link: '/reports/appointments-charts',
            value: 0
        },
        {
            title: 'Vitals History',
            description: 'Today',
            icon: Clock,
            link: '/reports/vitals-history',
            value: 0
        },
        {
            title: 'Sleep Charts',
            description: 'Today',
            icon: Moon,
            link: '/reports/sleep-charts',
            value: 0
        },
        {
            title: 'Staff Charts',
            description: 'Today',
            icon: UserCheck,
            link: '/reports/staff-charts',
            value: 0
        },
    ];

    return (
        <div className="min-h-screen bg-gradient-to-br from-[#F5F5DC] to-[#E6E6D4]">
            {/* Main Content */}
            <div className="max-w-7xl mx-auto px-4 md:px-6 py-4 md:py-8">
                {/* Page Title */}
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-[#2D5016] mb-2">Chart Reports</h1>
                    <p className="text-gray-600">Access and view detailed analytics across all report categories</p>
                </div>

                {/* Chart Cards Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {chartPages.map((page, index) => {
                        const Icon = page.icon;
                        return (
                            <div
                                key={index}
                                onClick={() => navigate(page.link)}
                                className="group relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden cursor-pointer border border-gray-100"
                            >
                                {/* Gradient decoration */}
                                <div className="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#2D5016] to-[#4a7a2a]"></div>
                                
                                {/* Content */}
                                <div className="p-6">
                                    <div className="flex items-start justify-between mb-4">
                                        <div className="flex-1">
                                            <p className="text-[#8B4513] text-sm font-semibold uppercase tracking-wide mb-1">
                                                {page.title}
                                            </p>
                                            <div className="flex items-baseline space-x-2">
                                                <p className="text-4xl font-bold text-[#2D5016]">
                                                    {page.value}
                                                </p>
                                            </div>
                                            {page.description && (
                                                <p className="text-gray-500 text-xs mt-2 flex items-center">
                                                    <Clock className="w-3 h-3 mr-1" />
                                                    {page.description}
                                                </p>
                                            )}
                                        </div>
                                        <div className="bg-green-50 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                            <Icon className="w-6 h-6 text-[#2D5016]" />
                                        </div>
                                    </div>
                                    
                                    {/* Hover effect */}
                                    <div className="flex items-center text-[#2D5016] text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <span>View details</span>
                                        <ArrowRight className="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" />
                                    </div>
                                </div>
                            </div>
                        );
                    })}
                </div>
            </div>
        </div>
    );
}
