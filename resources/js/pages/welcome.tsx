import React from 'react';
import { Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface Props {
    auth: {
        user: {
            id: number;
            name: string;
            email: string;
        } | null;
    };
    [key: string]: unknown;
}

export default function Welcome({ auth }: Props) {
    if (auth.user) {
        return (
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
                <div className="container mx-auto px-4 py-16">
                    <div className="max-w-4xl mx-auto">
                        {/* Header */}
                        <div className="text-center mb-16">
                            <div className="mb-6">
                                <span className="text-6xl">🏥</span>
                            </div>
                            <h1 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                                🔧 Hospital Engineering
                                <span className="block text-blue-600">Spare Parts Manager</span>
                            </h1>
                            <p className="text-xl text-gray-600 mb-8">
                                Professional inventory management system for hospital engineering departments
                            </p>
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                <Link href="/dashboard">
                                    <Button size="lg" className="text-lg px-8 py-4">
                                        📊 Go to Dashboard
                                    </Button>
                                </Link>
                                <Link href="/spare-parts">
                                    <Button variant="outline" size="lg" className="text-lg px-8 py-4">
                                        🔍 Browse Parts
                                    </Button>
                                </Link>
                            </div>
                        </div>

                        {/* Features Grid */}
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                            <div className="bg-white rounded-lg p-8 shadow-lg border-2 border-blue-100">
                                <div className="text-4xl mb-4">📦</div>
                                <h3 className="text-xl font-semibold mb-3">Inventory Management</h3>
                                <p className="text-gray-600">
                                    Track spare parts with detailed information including stock levels, 
                                    locations, and pricing
                                </p>
                            </div>

                            <div className="bg-white rounded-lg p-8 shadow-lg border-2 border-green-100">
                                <div className="text-4xl mb-4">📊</div>
                                <h3 className="text-xl font-semibold mb-3">Usage Tracking</h3>
                                <p className="text-gray-600">
                                    Record spare part usage with automatic stock updates and 
                                    approval workflows
                                </p>
                            </div>

                            <div className="bg-white rounded-lg p-8 shadow-lg border-2 border-purple-100">
                                <div className="text-4xl mb-4">🏢</div>
                                <h3 className="text-xl font-semibold mb-3">Supplier Management</h3>
                                <p className="text-gray-600">
                                    Manage supplier information and maintain vendor relationships
                                </p>
                            </div>

                            <div className="bg-white rounded-lg p-8 shadow-lg border-2 border-orange-100">
                                <div className="text-4xl mb-4">⚠️</div>
                                <h3 className="text-xl font-semibold mb-3">Low Stock Alerts</h3>
                                <p className="text-gray-600">
                                    Automatic alerts when spare parts reach minimum stock levels
                                </p>
                            </div>

                            <div className="bg-white rounded-lg p-8 shadow-lg border-2 border-red-100">
                                <div className="text-4xl mb-4">👥</div>
                                <h3 className="text-xl font-semibold mb-3">Role-Based Access</h3>
                                <p className="text-gray-600">
                                    Staff and Manager roles with appropriate permissions and workflows
                                </p>
                            </div>

                            <div className="bg-white rounded-lg p-8 shadow-lg border-2 border-teal-100">
                                <div className="text-4xl mb-4">📈</div>
                                <h3 className="text-xl font-semibold mb-3">Reporting</h3>
                                <p className="text-gray-600">
                                    Generate reports on stock levels, usage patterns, and inventory value
                                </p>
                            </div>
                        </div>

                        {/* User Roles */}
                        <div className="grid md:grid-cols-2 gap-8 mb-16">
                            <div className="bg-white rounded-lg p-8 shadow-lg">
                                <div className="text-4xl mb-4">👨‍🔧</div>
                                <h3 className="text-2xl font-semibold mb-4 text-blue-600">Staff Engineering</h3>
                                <ul className="space-y-2 text-gray-600">
                                    <li>✅ View spare parts inventory</li>
                                    <li>✅ Submit usage requests</li>
                                    <li>✅ Track request status</li>
                                    <li>✅ Search spare parts database</li>
                                </ul>
                            </div>

                            <div className="bg-white rounded-lg p-8 shadow-lg">
                                <div className="text-4xl mb-4">👨‍💼</div>
                                <h3 className="text-2xl font-semibold mb-4 text-green-600">Manager</h3>
                                <ul className="space-y-2 text-gray-600">
                                    <li>✅ All Staff Engineering features</li>
                                    <li>✅ Add, edit, delete spare parts</li>
                                    <li>✅ Approve/reject usage requests</li>
                                    <li>✅ Manage suppliers</li>
                                    <li>✅ Update stock levels</li>
                                    <li>✅ Generate reports</li>
                                </ul>
                            </div>
                        </div>

                        {/* CTA Section */}
                        <div className="text-center bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg p-12 text-white">
                            <h2 className="text-3xl font-bold mb-4">Ready to Get Started?</h2>
                            <p className="text-xl mb-8 opacity-90">
                                Streamline your hospital engineering spare parts management today
                            </p>
                            <Link href="/dashboard">
                                <Button size="lg" variant="secondary" className="text-lg px-8 py-4">
                                    🚀 Access Dashboard
                                </Button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
            <div className="container mx-auto px-4 py-16">
                <div className="max-w-4xl mx-auto">
                    {/* Header */}
                    <div className="text-center mb-16">
                        <div className="mb-6">
                            <span className="text-6xl">🏥</span>
                        </div>
                        <h1 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                            🔧 Hospital Engineering
                            <span className="block text-blue-600">Spare Parts Manager</span>
                        </h1>
                        <p className="text-xl text-gray-600 mb-8">
                            Professional inventory management system for hospital engineering departments
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link href="/login">
                                <Button size="lg" className="text-lg px-8 py-4">
                                    🔑 Login
                                </Button>
                            </Link>
                            <Link href="/register">
                                <Button variant="outline" size="lg" className="text-lg px-8 py-4">
                                    📝 Register
                                </Button>
                            </Link>
                        </div>
                    </div>

                    {/* Demo Screenshot Placeholder */}
                    <div className="mb-16">
                        <div className="bg-white rounded-lg shadow-xl p-8 border">
                            <div className="bg-gradient-to-r from-blue-100 to-indigo-100 rounded-lg h-96 flex items-center justify-center">
                                <div className="text-center">
                                    <div className="text-6xl mb-4">📊</div>
                                    <h3 className="text-2xl font-semibold text-gray-700 mb-2">Dashboard Preview</h3>
                                    <p className="text-gray-600">
                                        Real-time inventory tracking, usage monitoring, and low stock alerts
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Features Grid */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                        <div className="bg-white rounded-lg p-8 shadow-lg border-2 border-blue-100">
                            <div className="text-4xl mb-4">📦</div>
                            <h3 className="text-xl font-semibold mb-3">Inventory Management</h3>
                            <p className="text-gray-600">
                                Track spare parts with detailed information including stock levels, 
                                locations, and pricing
                            </p>
                        </div>

                        <div className="bg-white rounded-lg p-8 shadow-lg border-2 border-green-100">
                            <div className="text-4xl mb-4">📊</div>
                            <h3 className="text-xl font-semibold mb-3">Usage Tracking</h3>
                            <p className="text-gray-600">
                                Record spare part usage with automatic stock updates and 
                                approval workflows
                            </p>
                        </div>

                        <div className="bg-white rounded-lg p-8 shadow-lg border-2 border-purple-100">
                            <div className="text-4xl mb-4">🏢</div>
                            <h3 className="text-xl font-semibold mb-3">Supplier Management</h3>
                            <p className="text-gray-600">
                                Manage supplier information and maintain vendor relationships
                            </p>
                        </div>

                        <div className="bg-white rounded-lg p-8 shadow-lg border-2 border-orange-100">
                            <div className="text-4xl mb-4">⚠️</div>
                            <h3 className="text-xl font-semibold mb-3">Low Stock Alerts</h3>
                            <p className="text-gray-600">
                                Automatic alerts when spare parts reach minimum stock levels
                            </p>
                        </div>

                        <div className="bg-white rounded-lg p-8 shadow-lg border-2 border-red-100">
                            <div className="text-4xl mb-4">👥</div>
                            <h3 className="text-xl font-semibold mb-3">Role-Based Access</h3>
                            <p className="text-gray-600">
                                Staff and Manager roles with appropriate permissions and workflows
                            </p>
                        </div>

                        <div className="bg-white rounded-lg p-8 shadow-lg border-2 border-teal-100">
                            <div className="text-4xl mb-4">📈</div>
                            <h3 className="text-xl font-semibold mb-3">Reporting</h3>
                            <p className="text-gray-600">
                                Generate reports on stock levels, usage patterns, and inventory value
                            </p>
                        </div>
                    </div>

                    {/* User Roles */}
                    <div className="grid md:grid-cols-2 gap-8 mb-16">
                        <div className="bg-white rounded-lg p-8 shadow-lg">
                            <div className="text-4xl mb-4">👨‍🔧</div>
                            <h3 className="text-2xl font-semibold mb-4 text-blue-600">Staff Engineering</h3>
                            <ul className="space-y-2 text-gray-600">
                                <li>✅ View spare parts inventory</li>
                                <li>✅ Submit usage requests</li>
                                <li>✅ Track request status</li>
                                <li>✅ Search spare parts database</li>
                            </ul>
                        </div>

                        <div className="bg-white rounded-lg p-8 shadow-lg">
                            <div className="text-4xl mb-4">👨‍💼</div>
                            <h3 className="text-2xl font-semibold mb-4 text-green-600">Manager</h3>
                            <ul className="space-y-2 text-gray-600">
                                <li>✅ All Staff Engineering features</li>
                                <li>✅ Add, edit, delete spare parts</li>
                                <li>✅ Approve/reject usage requests</li>
                                <li>✅ Manage suppliers</li>
                                <li>✅ Update stock levels</li>
                                <li>✅ Generate reports</li>
                            </ul>
                        </div>
                    </div>

                    {/* CTA Section */}
                    <div className="text-center bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg p-12 text-white">
                        <h2 className="text-3xl font-bold mb-4">Ready to Get Started?</h2>
                        <p className="text-xl mb-8 opacity-90">
                            Join hospital engineering teams using our spare parts management system
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link href="/register">
                                <Button size="lg" variant="secondary" className="text-lg px-8 py-4">
                                    🚀 Get Started Free
                                </Button>
                            </Link>
                            <Link href="/login">
                                <Button size="lg" variant="outline" className="text-lg px-8 py-4 bg-transparent border-white text-white hover:bg-white hover:text-blue-600">
                                    🔑 Sign In
                                </Button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}