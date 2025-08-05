<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SparePart;
use App\Models\Supplier;
use App\Models\UsageRecord;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Common stats for both roles
        $stats = [
            'total_spare_parts' => SparePart::active()->count(),
            'low_stock_items' => SparePart::lowStock()->count(),
            'pending_requests' => UsageRecord::pending()->count(),
            'total_suppliers' => Supplier::active()->count(),
        ];

        // Recent activity
        $recentUsage = UsageRecord::with(['sparePart', 'user'])
            ->when(!$user->is_manager, function ($query) {
                return $query->where('user_id', auth()->id());
            })
            ->latest()
            ->take(5)
            ->get();

        // Low stock alerts
        $lowStockItems = SparePart::with('supplier')
            ->lowStock()
            ->active()
            ->take(5)
            ->get();

        // Additional stats for managers
        $managerStats = [];
        if ($user->is_manager) {
            $managerStats = [
                'total_inventory_value' => SparePart::selectRaw('SUM(quantity * price) as total')->value('total') ?? 0,
                'this_month_usage' => UsageRecord::approved()
                    ->whereMonth('usage_date', now()->month)
                    ->sum('quantity_used'),
                'pending_approvals' => UsageRecord::pending()->count(),
            ];
        }

        return Inertia::render('dashboard', [
            'stats' => array_merge($stats, $managerStats),
            'recentUsage' => $recentUsage,
            'lowStockItems' => $lowStockItems,
            'user' => $user->load('role')
        ]);
    }
}