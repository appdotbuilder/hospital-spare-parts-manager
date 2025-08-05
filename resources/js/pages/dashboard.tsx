import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/components/app-layout';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';

interface Props {
    stats: {
        total_spare_parts: number;
        low_stock_items: number;
        pending_requests: number;
        total_suppliers: number;
        total_inventory_value?: number;
        this_month_usage?: number;
        pending_approvals?: number;
    };
    recentUsage: Array<{
        id: number;
        quantity_used: number;
        purpose: string;
        usage_date: string;
        status: string;
        spare_part: {
            name: string;
            code: string;
        };
        user: {
            name: string;
        };
    }>;
    lowStockItems: Array<{
        id: number;
        name: string;
        code: string;
        quantity: number;
        minimum_stock: number;
        storage_location: string;
    }>;
    user: {
        name: string;
        is_manager: boolean;
        is_staff: boolean;
        role: {
            display_name: string;
        };
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ stats, recentUsage, lowStockItems, user }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            
            <div className="space-y-6">
                {/* Welcome Section */}
                <div className="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border">
                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="text-2xl font-bold text-gray-900">
                                Welcome back, {user.name}! 👋
                            </h1>
                            <p className="text-gray-600 mt-1">
                                Role: <span className="font-medium text-blue-600">{user.role?.display_name || 'User'}</span>
                            </p>
                        </div>
                        <div className="text-4xl">🏥</div>
                    </div>
                </div>

                {/* Stats Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div className="bg-white rounded-lg p-6 shadow-sm border">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Total Spare Parts</p>
                                <p className="text-2xl font-bold text-gray-900">{stats.total_spare_parts}</p>
                            </div>
                            <div className="text-3xl text-blue-500">📦</div>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-6 shadow-sm border">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Low Stock Items</p>
                                <p className="text-2xl font-bold text-red-600">{stats.low_stock_items}</p>
                            </div>
                            <div className="text-3xl text-red-500">⚠️</div>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-6 shadow-sm border">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Pending Requests</p>
                                <p className="text-2xl font-bold text-orange-600">{stats.pending_requests}</p>
                            </div>
                            <div className="text-3xl text-orange-500">⏳</div>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg p-6 shadow-sm border">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Active Suppliers</p>
                                <p className="text-2xl font-bold text-green-600">{stats.total_suppliers}</p>
                            </div>
                            <div className="text-3xl text-green-500">🏢</div>
                        </div>
                    </div>
                </div>

                {/* Manager-only stats */}
                {user.is_manager && (
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div className="bg-white rounded-lg p-6 shadow-sm border">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-medium text-gray-600">Inventory Value</p>
                                    <p className="text-2xl font-bold text-purple-600">
                                        ${stats.total_inventory_value?.toLocaleString() || '0'}
                                    </p>
                                </div>
                                <div className="text-3xl text-purple-500">💰</div>
                            </div>
                        </div>

                        <div className="bg-white rounded-lg p-6 shadow-sm border">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-medium text-gray-600">This Month Usage</p>
                                    <p className="text-2xl font-bold text-indigo-600">{stats.this_month_usage || 0}</p>
                                </div>
                                <div className="text-3xl text-indigo-500">📊</div>
                            </div>
                        </div>

                        <div className="bg-white rounded-lg p-6 shadow-sm border">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="text-sm font-medium text-gray-600">Pending Approvals</p>
                                    <p className="text-2xl font-bold text-yellow-600">{stats.pending_approvals || 0}</p>
                                </div>
                                <div className="text-3xl text-yellow-500">✋</div>
                            </div>
                        </div>
                    </div>
                )}

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Recent Usage */}
                    <div className="bg-white rounded-lg shadow-sm border">
                        <div className="p-6 border-b">
                            <div className="flex items-center justify-between">
                                <h2 className="text-lg font-semibold text-gray-900">Recent Usage Records</h2>
                                <Link href="/usage-records">
                                    <Button variant="outline" size="sm">View All</Button>
                                </Link>
                            </div>
                        </div>
                        <div className="p-6">
                            {recentUsage.length > 0 ? (
                                <div className="space-y-4">
                                    {recentUsage.map((record) => (
                                        <div key={record.id} className="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                            <div className="flex-1">
                                                <p className="font-medium text-gray-900">{record.spare_part.name}</p>
                                                <p className="text-sm text-gray-500">
                                                    {record.purpose} • {record.quantity_used} units
                                                </p>
                                                <p className="text-xs text-gray-400">
                                                    by {record.user.name} • {new Date(record.usage_date).toLocaleDateString()}
                                                </p>
                                            </div>
                                            <span className={`px-2 py-1 text-xs rounded-full ${
                                                record.status === 'approved' 
                                                    ? 'bg-green-100 text-green-800' 
                                                    : record.status === 'pending'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : 'bg-red-100 text-red-800'
                                            }`}>
                                                {record.status}
                                            </span>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div className="text-center py-8 text-gray-500">
                                    <div className="text-4xl mb-2">📋</div>
                                    <p>No recent usage records</p>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Low Stock Alerts */}
                    <div className="bg-white rounded-lg shadow-sm border">
                        <div className="p-6 border-b">
                            <div className="flex items-center justify-between">
                                <h2 className="text-lg font-semibold text-gray-900">Low Stock Alerts</h2>
                                <Link href="/spare-parts?low_stock=true">
                                    <Button variant="outline" size="sm">View All</Button>
                                </Link>
                            </div>
                        </div>
                        <div className="p-6">
                            {lowStockItems.length > 0 ? (
                                <div className="space-y-4">
                                    {lowStockItems.map((item) => (
                                        <div key={item.id} className="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                            <div className="flex-1">
                                                <p className="font-medium text-gray-900">{item.name}</p>
                                                <p className="text-sm text-gray-500">
                                                    Code: {item.code} • {item.storage_location}
                                                </p>
                                            </div>
                                            <div className="text-right">
                                                <p className="text-sm font-medium text-red-600">
                                                    {item.quantity}/{item.minimum_stock}
                                                </p>
                                                <p className="text-xs text-gray-400">Stock/Min</p>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div className="text-center py-8 text-gray-500">
                                    <div className="text-4xl mb-2">✅</div>
                                    <p>All items are well stocked</p>
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                {/* Quick Actions */}
                <div className="bg-white rounded-lg shadow-sm border p-6">
                    <h2 className="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                    <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <Link href="/spare-parts">
                            <Button variant="outline" className="w-full justify-start">
                                <span className="mr-2">📦</span>
                                View Spare Parts
                            </Button>
                        </Link>
                        
                        <Link href="/usage-records/create">
                            <Button variant="outline" className="w-full justify-start">
                                <span className="mr-2">📝</span>
                                Record Usage
                            </Button>
                        </Link>

                        {user.is_manager && (
                            <>
                                <Link href="/spare-parts/create">
                                    <Button variant="outline" className="w-full justify-start">
                                        <span className="mr-2">➕</span>
                                        Add Spare Part
                                    </Button>
                                </Link>
                                
                                <Link href="/suppliers">
                                    <Button variant="outline" className="w-full justify-start">
                                        <span className="mr-2">🏢</span>
                                        Manage Suppliers
                                    </Button>
                                </Link>
                            </>
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}