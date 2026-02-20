import React, { useState, useEffect, useRef } from 'react';
import { Navigate } from 'react-router-dom';
import api from '../services/api';

const VALIDATED_KEY = 'token_validated_at';
const VALIDATION_TTL_MS = 5 * 60 * 1000;

function needsValidation() {
    const last = sessionStorage.getItem(VALIDATED_KEY);
    if (!last) return true;
    return Date.now() - Number(last) > VALIDATION_TTL_MS;
}

export default function ProtectedRoute({ children }) {
    const token = localStorage.getItem('auth_token');
    const skipValidation = token && !needsValidation();
    const [status, setStatus] = useState(
        !token ? 'unauthenticated' : skipValidation ? 'authenticated' : 'validating'
    );
    const didValidate = useRef(false);

    useEffect(() => {
        if (!token) {
            setStatus('unauthenticated');
            return;
        }

        if (skipValidation || didValidate.current) return;
        didValidate.current = true;

        let cancelled = false;

        api.post('/token/validate')
            .then(() => {
                if (cancelled) return;
                sessionStorage.setItem(VALIDATED_KEY, String(Date.now()));
                setStatus('authenticated');
            })
            .catch(() => {
                if (cancelled) return;
                sessionStorage.removeItem(VALIDATED_KEY);
                setStatus('unauthenticated');
            });

        return () => { cancelled = true; };
    }, [token, skipValidation]);

    if (status === 'unauthenticated') {
        return <Navigate to="/login" replace />;
    }

    if (status === 'validating') {
        return (
            <div className="flex items-center justify-center min-h-screen bg-gray-50">
                <div className="text-center">
                    <div className="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[var(--theme-primary)]"></div>
                    <p className="mt-4 text-sm text-gray-500">Verifying session...</p>
                </div>
            </div>
        );
    }

    return children;
}
