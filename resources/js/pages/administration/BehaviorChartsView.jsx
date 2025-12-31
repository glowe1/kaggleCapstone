import React, { useState } from 'react';
import { useQuery } from '@tanstack/react-query';
import api from '../../services/api';
import { 
    ClipboardList, 
    Filter,
    Eye,
    Calendar,
    User,
    CheckCircle2,
    Clock,
    FileText,
    Download,
    RefreshCw
} from 'lucide-react';
import { formatPacificDate } from '../../utils/pacificTime';

export default function BehaviorChartsView() {
    const [branchId, setBranchId] = useState(null);
    const [residentId, setResidentId] = useState(null);
    const [month, setMonth] = useState(() => {
        const now = new Date();
        return String(now.getMonth() + 1).padStart(2, '0');
    });
    const [year, setYear] = useState(() => {
        return new Date().getFullYear().toString();
    });
    const [branches, setBranches] = useState([]);
    const [residents, setResidents] = useState([]);

    // Fetch branches and residents
    React.useEffect(() => {
        api.get('/branches', { params: { per_page: 100 } })
            .then(res => setBranches(res.data?.data || []))
            .catch(() => {});
    }, []);

    React.useEffect(() => {
        if (branchId) {
            api.get('/residents', { params: { per_page: 100, branch_id: branchId, is_active: 1 } })
                .then(res => setResidents(res.data?.data || []))
                .catch(() => {});
        } else {
            setResidents([]);
            setResidentId(null);
        }
    }, [branchId]);

    // Fetch behavior charts
    const { data: chartsData, isLoading, refetch } = useQuery({
        queryKey: ['behavior-charts', branchId, residentId, month, year],
        queryFn: async () => {
            const params = {
                per_page: 50,
                month: month,
                year: year,
            };
            if (branchId) params.branch_id = branchId;
            if (residentId) params.resident_id = residentId;
            const response = await api.get('/resident-charts', { params });
            return response.data;
        },
        enabled: !!(branchId && residentId), // Only fetch when both filters are selected
    });

    const charts = chartsData?.data || [];

    const handleViewChart = (chart) => {
        // Open chart details in a modal or navigate to detail page
        // For now, we'll show an alert with chart details
        console.log('View chart:', chart);
        // TODO: Implement chart detail view modal
    };

    const handleExport = () => {
        if (!charts.length) return;
        
        let csv = 'Date,Resident,Chart Status,Submitted At,Caregiver,Items Count,Logs Count\n';
        charts.forEach(chart => {
            csv += `${chart.chart_date},`;
            csv += `${chart.resident?.first_name || ''} ${chart.resident?.last_name || ''},`;
            csv += `${chart.status},`;
            csv += `${chart.submitted_at || 'N/A'},`;
            csv += `${chart.caregiver?.name || 'N/A'},`;
            csv += `${chart.items?.length || 0},`;
            csv += `${chart.logs?.length || 0}\n`;
        });
        
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `behavior-charts-${year}-${month}.csv`;
        a.click();
        window.URL.revokeObjectURL(url);
    };

    const getStatusBadge = (status) => {
        if (status === 'submitted') {
            return (
                <span className="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <CheckCircle2 className="w-3 h-3" />
                    Submitted
                </span>
            );
        }
        return (
            <span className="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                <Clock className="w-3 h-3" />
                Draft
            </span>
        );
    };

    return (
        <div className="space-y-6">
            {/* Header */}
            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900 flex items-center gap-2">
                            <ClipboardList className="w-8 h-8 text-[var(--theme-primary)]" />
                            Behavior Charts
                        </h1>
                        <p className="mt-1 text-sm text-gray-500">
                            View and manage caregiver-submitted behavior charts
                        </p>
                    </div>
                    <div className="flex items-center gap-3">
                        {charts.length > 0 && (
                            <button
                                onClick={handleExport}
                                className="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition"
                            >
                                <Download className="h-4 w-4" />
                                Export
                            </button>
                        )}
                        <button
                            onClick={() => refetch()}
                            className="inline-flex items-center gap-2 px-4 py-2 bg-[var(--theme-primary)] text-[var(--theme-text-on-primary)] rounded-lg text-sm font-medium hover:bg-[var(--theme-primary-hover)] transition"
                        >
                            <RefreshCw className="h-4 w-4" />
                            Refresh
                        </button>
                    </div>
                </div>
            </div>

            {/* Filters */}
            <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div className="flex flex-wrap items-end gap-4">
                    <div className="flex-1 min-w-[200px]">
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            <Filter className="inline h-4 w-4 mr-1" />
                            Select Branch
                        </label>
                        <select
                            value={branchId || ''}
                            onChange={(e) => {
                                setBranchId(e.target.value || null);
                                setResidentId(null);
                            }}
                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--theme-primary)] focus:border-transparent"
                        >
                            <option value="">All Branches</option>
                            {branches.map(b => (
                                <option key={b.id} value={b.id}>{b.name}</option>
                            ))}
                        </select>
                    </div>
                    <div className="flex-1 min-w-[200px]">
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            <Filter className="inline h-4 w-4 mr-1" />
                            Select Resident
                        </label>
                        <select
                            value={residentId || ''}
                            onChange={(e) => setResidentId(e.target.value || null)}
                            disabled={!branchId}
                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--theme-primary)] focus:border-transparent disabled:bg-gray-100 disabled:cursor-not-allowed"
                        >
                            <option value="">Select Resident</option>
                            {residents.map(r => (
                                <option key={r.id} value={r.id}>
                                    {r.first_name} {r.last_name}
                                </option>
                            ))}
                        </select>
                    </div>
                    <div className="flex-1 min-w-[150px]">
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            <Filter className="inline h-4 w-4 mr-1" />
                            Month
                        </label>
                        <select
                            value={month}
                            onChange={(e) => setMonth(e.target.value)}
                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--theme-primary)] focus:border-transparent"
                        >
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div className="flex-1 min-w-[120px]">
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            <Filter className="inline h-4 w-4 mr-1" />
                            Year
                        </label>
                        <input
                            type="number"
                            value={year}
                            onChange={(e) => setYear(e.target.value)}
                            min="2020"
                            max="2099"
                            className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--theme-primary)] focus:border-transparent"
                        />
                    </div>
                </div>
            </div>

            {/* Charts Grid */}
            {!branchId || !residentId ? (
                <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <Filter className="w-12 h-12 text-gray-300 mx-auto mb-4" />
                    <p className="text-gray-600 font-medium">Please select a branch and resident to view behavior charts</p>
                </div>
            ) : isLoading ? (
                <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <div className="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-[var(--theme-primary)]"></div>
                    <p className="mt-4 text-gray-600">Loading charts...</p>
                </div>
            ) : charts.length === 0 ? (
                <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <ClipboardList className="w-12 h-12 text-gray-300 mx-auto mb-4" />
                    <p className="text-gray-600 font-medium">No behavior charts found for the selected filters</p>
                </div>
            ) : (
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {charts.map((chart) => (
                        <div key={chart.id} className="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                            <div className="flex items-start justify-between mb-4">
                                <div className="flex-1">
                                    <div className="flex items-center gap-2 mb-2">
                                        <Calendar className="w-4 h-4 text-gray-400" />
                                        <span className="text-sm font-medium text-gray-900">
                                            {formatPacificDate(chart.chart_date)}
                                        </span>
                                    </div>
                                    <div className="flex items-center gap-2 mb-2">
                                        <User className="w-4 h-4 text-gray-400" />
                                        <span className="text-sm text-gray-700">
                                            {chart.resident?.first_name} {chart.resident?.last_name}
                                        </span>
                                    </div>
                                    {chart.caregiver && (
                                        <p className="text-xs text-gray-500">
                                            Submitted by: {chart.caregiver.name}
                                        </p>
                                    )}
                                </div>
                                {getStatusBadge(chart.status)}
                            </div>

                            <div className="space-y-2 mb-4">
                                <div className="flex items-center justify-between text-sm">
                                    <span className="text-gray-600">Items:</span>
                                    <span className="font-medium text-gray-900">{chart.items?.length || 0}</span>
                                </div>
                                <div className="flex items-center justify-between text-sm">
                                    <span className="text-gray-600">Logs:</span>
                                    <span className="font-medium text-gray-900">{chart.logs?.length || 0}</span>
                                </div>
                                {chart.submitted_at && (
                                    <div className="flex items-center justify-between text-sm">
                                        <span className="text-gray-600">Submitted:</span>
                                        <span className="font-medium text-gray-900">
                                            {new Date(chart.submitted_at).toLocaleString()}
                                        </span>
                                    </div>
                                )}
                            </div>

                            <button
                                onClick={() => handleViewChart(chart)}
                                className="w-full px-4 py-2 bg-[var(--theme-primary)] text-white rounded-lg hover:bg-[var(--theme-primary-hover)] transition-colors flex items-center justify-center gap-2 text-sm font-medium"
                            >
                                <Eye className="w-4 h-4" />
                                View Details
                            </button>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
}

