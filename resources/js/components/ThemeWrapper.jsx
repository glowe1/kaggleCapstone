import React from 'react';
import { useQuery } from '@tanstack/react-query';
import api from '../services/api';
import { ThemeProvider } from '../contexts/ThemeContext';

/**
 * Wrapper component that fetches user data and provides theme
 * This ensures theme is available at the root level
 */
export default function ThemeWrapper({ children }) {
    // Use window.location instead of useLocation since ThemeWrapper is outside Router
    // Read pathname directly - it will be correct on initial render and after page reloads
    const pathname = typeof window !== 'undefined' ? window.location.pathname : '';
    
    // Extract facility ID from URL if viewing a facility page
    const facilityIdFromUrl = React.useMemo(() => {
        if (!pathname) return null;
        const match = pathname.match(/\/facilities\/(\d+)/) || 
                     pathname.match(/\/super-admin\/facilities\/(\d+)/);
        return match ? match[1] : null;
    }, [pathname]);
    
    const { data: userData } = useQuery({
        queryKey: ['current-user'],
        queryFn: async () => {
            try {
                const response = await api.get('/user');
                return response.data;
            } catch (err) {
                // Don't log 401 errors - they're expected when not logged in
                if (err.response?.status !== 401) {
                    console.error('Failed to fetch user for theme:', err);
                }
                return null;
            }
        },
        staleTime: 1 * 60 * 1000, // Reduced to 1 minute for faster updates
        retry: false, // Don't retry on 401 errors
    });
    
    // Fetch facility branding if viewing a specific facility page
    const { data: facilityData } = useQuery({
        queryKey: ['facility', facilityIdFromUrl],
        queryFn: async () => {
            try {
                const response = await api.get(`/facilities/${facilityIdFromUrl}`);
                return response.data;
            } catch (err) {
                return null;
            }
        },
        enabled: !!facilityIdFromUrl && userData?.role === 'super_admin', // Only for super admins viewing facilities
        staleTime: 1 * 60 * 1000,
    });

    // Fetch super admin theme if user is super admin
    const isSuperAdmin = userData?.role === 'super_admin';
    const { data: superAdminTheme } = useQuery({
        queryKey: ['super-admin-theme'],
        queryFn: async () => {
            try {
                const response = await api.get('/system-settings/super-admin-theme');
                return response.data.data;
            } catch (err) {
                console.error('Failed to fetch super admin theme:', err);
                return null;
            }
        },
        enabled: isSuperAdmin, // Only fetch if user is super admin
        staleTime: 5 * 60 * 1000, // Cache for 5 minutes
        retry: 1,
    });

    // Determine facility branding
    // If super admin viewing a facility, use that facility's branding
    // Otherwise, if super admin, use super admin theme colors
    // Otherwise, use user's facility branding
    const facilityBranding = React.useMemo(() => {
        // If viewing a specific facility as super admin, use that facility's branding
        if (isSuperAdmin && facilityData) {
            return {
                name: facilityData.name,
                logo: facilityData.logo_url || facilityData.logo || '/images/logonew.png',
                primary_color: facilityData.primary_color || '#1E3A5F',
                secondary_color: facilityData.secondary_color || '#86EFAC',
                accent_color: facilityData.accent_color || '#FFFFFF',
            };
        }
        
        // If super admin with super admin theme, use super admin theme colors
        if (isSuperAdmin && superAdminTheme) {
            // For super admin, use super admin theme colors but keep facility branding structure
            return {
                ...userData?.facility_branding,
                primary_color: superAdminTheme.primary_color,
                secondary_color: superAdminTheme.secondary_color,
                accent_color: superAdminTheme.accent_color,
            };
        }
        
        // Otherwise, use user's facility branding
        return userData?.facility_branding || null;
    }, [userData, isSuperAdmin, superAdminTheme, facilityData]);

    return (
        <ThemeProvider facilityBranding={facilityBranding}>
            {children}
        </ThemeProvider>
    );
}

