import React from 'react';
import { useNavigate } from 'react-router-dom';
import {
    ClipboardList,
    Heart,
    Moon,
    ChevronRight,
    Activity,
    Eye,
    BarChart2,
} from 'lucide-react';
import SectionHub from '../../components/SectionHub';

const FEATURES = [
    {
        id: 'medication-history',
        title: 'Medication History',
        description: 'Browse and export the complete administration log across all residents.',
        icon: ClipboardList,
        accent: 'bg-blue-50 text-blue-600 border-blue-100',
        iconBg: 'bg-blue-100',
        path: '/medication-history',
    },
    {
        id: 'vitals',
        title: 'Vital Signs',
        description: 'Record blood pressure, temperature, pulse, SpO₂, weight, and more.',
        icon: Heart,
        accent: 'bg-rose-50 text-rose-600 border-rose-100',
        iconBg: 'bg-rose-100',
        path: '/vitals',
        subLinks: [
            { label: 'Record Vitals', path: '/vitals' },
            { label: 'View All Vitals', path: '/view-vitals' },
        ],
    },
    {
        id: 'sleep',
        title: 'Sleep Tracking',
        description: 'Log sleep records and review resident sleep patterns over time.',
        icon: Moon,
        accent: 'bg-indigo-50 text-indigo-600 border-indigo-100',
        iconBg: 'bg-indigo-100',
        path: '/sleep',
        subLinks: [
            { label: 'Sleep Records', path: '/sleep' },
            { label: 'Sleep Patterns', path: '/sleep-patterns' },
        ],
    },
];

export default function ClinicalHubPage() {
    return (
        <SectionHub
            title="Clinical"
            subtitle="Resident health monitoring and clinical records"
            features={FEATURES}
        />
    );
}
