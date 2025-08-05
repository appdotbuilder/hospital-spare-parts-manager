<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsageRecordRequest;
use App\Models\SparePart;
use App\Models\UsageRecord;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsageRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = UsageRecord::with(['sparePart', 'user', 'approver'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->user_id, function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->when($request->date_from, function ($query, $dateFrom) {
                return $query->whereDate('usage_date', '>=', $dateFrom);
            })
            ->when($request->date_to, function ($query, $dateTo) {
                return $query->whereDate('usage_date', '<=', $dateTo);
            });

        // If user is not manager, only show their own records
        if (!auth()->user()->is_manager) {
            $query->where('user_id', auth()->id());
        }

        $usageRecords = $query->latest()->paginate(15)->withQueryString();

        return Inertia::render('usage-records/index', [
            'usageRecords' => $usageRecords,
            'filters' => $request->only(['status', 'user_id', 'date_from', 'date_to']),
            'stats' => [
                'pending' => UsageRecord::pending()->count(),
                'approved' => UsageRecord::approved()->count(),
                'total' => UsageRecord::count(),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $spareParts = SparePart::active()
            ->where('quantity', '>', 0)
            ->orderBy('name')
            ->get();

        return Inertia::render('usage-records/create', [
            'spareParts' => $spareParts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsageRecordRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';

        $usageRecord = UsageRecord::create($data);

        // If user is manager, auto-approve and reduce stock
        if (auth()->user()->is_manager) {
            $this->approveUsage($usageRecord);
        }

        return redirect()->route('usage-records.show', $usageRecord)
            ->with('success', 'Usage record submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UsageRecord $usageRecord)
    {
        // Users can only view their own records unless they're managers
        if (!auth()->user()->is_manager && $usageRecord->user_id !== auth()->id()) {
            abort(403);
        }

        $usageRecord->load(['sparePart.supplier', 'user', 'approver']);

        return Inertia::render('usage-records/show', [
            'usageRecord' => $usageRecord
        ]);
    }

    /**
     * Approve a usage record (managers only).
     */
    public function update(Request $request, UsageRecord $usageRecord)
    {
        if (!auth()->user()->is_manager) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string'
        ]);

        if ($request->status === 'approved') {
            $this->approveUsage($usageRecord);
        } else {
            $usageRecord->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'notes' => $request->notes
            ]);
        }

        return redirect()->route('usage-records.show', $usageRecord)
            ->with('success', 'Usage record ' . $request->status . ' successfully.');
    }

    /**
     * Approve usage and reduce stock.
     *
     * @param UsageRecord $usageRecord
     */
    protected function approveUsage(UsageRecord $usageRecord): void
    {
        $sparePart = $usageRecord->sparePart;

        // Check if there's enough stock
        if ($sparePart->quantity < $usageRecord->quantity_used) {
            throw new \Exception('Insufficient stock. Available: ' . $sparePart->quantity);
        }

        // Reduce stock
        $sparePart->decrement('quantity', $usageRecord->quantity_used);

        // Update usage record
        $usageRecord->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);
    }
}