import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AppLayout from '@/components/app-layout';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';

interface SparePart {
    id: number;
    name: string;
    code: string;
    quantity: number;
    storage_location: string;
    price: number;
    status: string;
    supplier?: {
        name: string;
    };
    is_low_stock: boolean;
}

interface Props {
    spareParts: {
        data: SparePart[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
    filters: {
        search?: string;
        status?: string;
        low_stock?: string;
    };
    stats: {
        total: number;
        active: number;
        low_stock: number;
        total_value: number;
    };
    auth: {
        user: {
            is_manager: boolean;
        };
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Spare Parts', href: '/spare-parts' },
];

export default function SparePartsIndex({ spareParts, filters, stats, auth }: Props) {
    const handleSearch = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        const formData = new FormData(e.currentTarget);
        const search = formData.get('search') as string;
        
        router.get('/spare-parts', {
            ...filters,
            search: search || undefined,
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const handleFilter = (key: string, value: string | undefined) => {
        router.get('/spare-parts', {
            ...filters,
            [key]: value,
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Spare Parts" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">Spare Parts Inventory</h1>
                        <p className="text-gray-600">Manage and track hospital engineering spare parts</p>
                    </div>
                    {auth.user.is_manager && (
                        <Link href="/spare-parts/create">
                            <Button>
                                <span className="mr-2">➕</span>
                                Add Spare Part
                            </Button>
                        </Link>
                    )}
                </div>

                {/* Stats */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div className="bg-white rounded-lg p-4 shadow-sm border">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600">Total Parts</p>
                                <p className="text-2xl font-bold">{stats.total}</p>
                            </div>
                            <div className="text-2xl">📦</div>
                        </div>
                    </div>
                    
                    <div className="bg-white rounded-lg p-4 shadow-sm border">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600">Active</p>
                                <p className="text-2xl font-bold text-green-600">{stats.active}</p>
                            </div>
                            <div className="text-2xl">✅</div>
                        </div>
                    </div>
                    
                    <div className="bg-white rounded-lg p-4 shadow-sm border">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600">Low Stock</p>
                                <p className="text-2xl font-bold text-red-600">{stats.low_stock}</p>
                            </div>
                            <div className="text-2xl">⚠️</div>
                        </div>
                    </div>
                    
                    <div className="bg-white rounded-lg p-4 shadow-sm border">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600">Total Value</p>
                                <p className="text-2xl font-bold text-blue-600">${stats.total_value.toLocaleString()}</p>
                            </div>
                            <div className="text-2xl">💰</div>
                        </div>
                    </div>
                </div>

                {/* Filters */}
                <div className="bg-white rounded-lg shadow-sm border p-6">
                    <form onSubmit={handleSearch} className="flex flex-col sm:flex-row gap-4">
                        <div className="flex-1">
                            <input
                                type="text"
                                name="search"
                                placeholder="Search spare parts..."
                                defaultValue={filters.search || ''}
                                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                        </div>
                        <div className="flex gap-2">
                            <select
                                value={filters.status || ''}
                                onChange={(e) => handleFilter('status', e.target.value || undefined)}
                                className="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            
                            <button
                                type="button"
                                onClick={() => handleFilter('low_stock', filters.low_stock === 'true' ? undefined : 'true')}
                                className={`px-4 py-2 rounded-md ${
                                    filters.low_stock === 'true'
                                        ? 'bg-red-100 text-red-800 border border-red-300'
                                        : 'bg-gray-100 text-gray-700 border border-gray-300'
                                }`}
                            >
                                Low Stock Only
                            </button>
                            
                            <Button type="submit">Search</Button>
                        </div>
                    </form>
                </div>

                {/* Table */}
                <div className="bg-white rounded-lg shadow-sm border overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Part Details
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stock
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Location
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Supplier
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {spareParts.data.map((part) => (
                                    <tr key={part.id} className="hover:bg-gray-50">
                                        <td className="px-6 py-4">
                                            <div>
                                                <div className="text-sm font-medium text-gray-900">{part.name}</div>
                                                <div className="text-sm text-gray-500">Code: {part.code}</div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className={`text-sm font-medium ${part.is_low_stock ? 'text-red-600' : 'text-gray-900'}`}>
                                                {part.quantity}
                                                {part.is_low_stock && (
                                                    <span className="ml-1 text-red-500">⚠️</span>
                                                )}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 text-sm text-gray-900">
                                            {part.storage_location}
                                        </td>
                                        <td className="px-6 py-4 text-sm text-gray-900">
                                            ${part.price.toFixed(2)}
                                        </td>
                                        <td className="px-6 py-4 text-sm text-gray-900">
                                            {part.supplier?.name || 'N/A'}
                                        </td>
                                        <td className="px-6 py-4">
                                            <span className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full ${
                                                part.status === 'active'
                                                    ? 'bg-green-100 text-green-800'
                                                    : 'bg-red-100 text-red-800'
                                            }`}>
                                                {part.status}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-sm font-medium">
                                            <div className="flex space-x-2">
                                                <Link href={`/spare-parts/${part.id}`}>
                                                    <Button variant="outline" size="sm">View</Button>
                                                </Link>
                                                {auth.user.is_manager && (
                                                    <Link href={`/spare-parts/${part.id}/edit`}>
                                                        <Button variant="outline" size="sm">Edit</Button>
                                                    </Link>
                                                )}
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    
                    {spareParts.data.length === 0 && (
                        <div className="text-center py-12">
                            <div className="text-4xl mb-4">📦</div>
                            <h3 className="text-lg font-medium text-gray-900 mb-2">No spare parts found</h3>
                            <p className="text-gray-500 mb-4">
                                {filters.search || filters.status || filters.low_stock
                                    ? 'Try adjusting your search criteria'
                                    : 'Get started by adding your first spare part'
                                }
                            </p>
                            {auth.user.is_manager && (
                                <Link href="/spare-parts/create">
                                    <Button>Add Spare Part</Button>
                                </Link>
                            )}
                        </div>
                    )}
                </div>

                {/* Pagination */}
                {spareParts.last_page > 1 && (
                    <div className="flex items-center justify-between">
                        <div className="text-sm text-gray-700">
                            Showing {((spareParts.current_page - 1) * spareParts.per_page) + 1} to{' '}
                            {Math.min(spareParts.current_page * spareParts.per_page, spareParts.total)} of{' '}
                            {spareParts.total} results
                        </div>
                        <div className="flex space-x-2">
                            {spareParts.current_page > 1 && (
                                <Link
                                    href={`/spare-parts?page=${spareParts.current_page - 1}`}
                                    preserveState
                                >
                                    <Button variant="outline">Previous</Button>
                                </Link>
                            )}
                            {spareParts.current_page < spareParts.last_page && (
                                <Link
                                    href={`/spare-parts?page=${spareParts.current_page + 1}`}
                                    preserveState
                                >
                                    <Button variant="outline">Next</Button>
                                </Link>
                            )}
                        </div>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}