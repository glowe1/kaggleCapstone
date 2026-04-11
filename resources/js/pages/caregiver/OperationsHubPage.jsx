import React from 'react';
import {
    Sparkles,
    ShoppingCart,
    Flame,
    AlertTriangle,
    CalendarClock,
    CheckSquare,
} from 'lucide-react';
import SectionHub from '../../components/SectionHub';

const FEATURES = [
    {
        id: 'housekeeping',
        title: 'Housekeeping',
        description: 'Manage cleaning assignments, schedules, and task completion.',
        icon: Sparkles,
        accent: 'bg-teal-50 text-teal-600 border-teal-100',
        iconBg: 'bg-teal-100',
        path: '/housekeeping',
        subLinks: [
            { label: 'Tasks', path: '/housekeeping' },
            { label: 'Schedule', path: '/housekeeping/schedule' },
            { label: 'Dashboard', path: '/housekeeping/dashboard' },
        ],
    },
    {
        id: 'grocery-status',
        title: 'Grocery Status',
        description: 'Track grocery orders, inventory levels, and delivery status.',
        icon: ShoppingCart,
        accent: 'bg-amber-50 text-amber-600 border-amber-100',
        iconBg: 'bg-amber-100',
        path: '/grocery-status',
    },
    {
        id: 'fire-drills',
        title: 'Fire Drills',
        description: 'Schedule, conduct, and record mandatory fire evacuation drills.',
        icon: Flame,
        accent: 'bg-orange-50 text-orange-600 border-orange-100',
        iconBg: 'bg-orange-100',
        path: '/fire-drills',
    },
    {
        id: 'incidents',
        title: 'Incident Reports',
        description: 'Document and track resident and facility incidents for compliance.',
        icon: AlertTriangle,
        accent: 'bg-red-50 text-red-600 border-red-100',
        iconBg: 'bg-red-100',
        path: '/incidents',
    },
    {
        id: 'leave-requests',
        title: 'Leave Requests',
        description: 'Submit and manage staff time-off and leave of absence requests.',
        icon: CalendarClock,
        accent: 'bg-purple-50 text-purple-600 border-purple-100',
        iconBg: 'bg-purple-100',
        path: '/leave-requests',
    },
];

export default function OperationsHubPage() {
    return (
        <SectionHub
            title="Operations"
            subtitle="Facility management, compliance, and staff operations"
            features={FEATURES}
        />
    );
}
