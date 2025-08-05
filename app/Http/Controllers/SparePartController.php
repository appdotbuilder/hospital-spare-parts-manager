<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSparePartRequest;
use App\Http\Requests\UpdateSparePartRequest;
use App\Models\SparePart;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SparePartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SparePart::with('supplier')
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('storage_location', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->low_stock === 'true', function ($query) {
                return $query->lowStock();
            });

        $spareParts = $query->latest()->paginate(15)->withQueryString();

        return Inertia::render('spare-parts/index', [
            'spareParts' => $spareParts,
            'filters' => $request->only(['search', 'status', 'low_stock']),
            'stats' => [
                'total' => SparePart::count(),
                'active' => SparePart::where('status', 'active')->count(),
                'low_stock' => SparePart::lowStock()->count(),
                'total_value' => SparePart::selectRaw('SUM(quantity * price) as total')->value('total') ?? 0,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::active()->orderBy('name')->get();

        return Inertia::render('spare-parts/create', [
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSparePartRequest $request)
    {
        $sparePart = SparePart::create($request->validated());

        return redirect()->route('spare-parts.show', $sparePart)
            ->with('success', 'Spare part created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SparePart $sparePart)
    {
        $sparePart->load(['supplier', 'usageRecords.user', 'usageRecords.approver']);

        return Inertia::render('spare-parts/show', [
            'sparePart' => $sparePart,
            'recentUsage' => $sparePart->usageRecords()
                ->with(['user', 'approver'])
                ->latest()
                ->take(10)
                ->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SparePart $sparePart)
    {
        $suppliers = Supplier::active()->orderBy('name')->get();

        return Inertia::render('spare-parts/edit', [
            'sparePart' => $sparePart,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSparePartRequest $request, SparePart $sparePart)
    {
        $sparePart->update($request->validated());

        return redirect()->route('spare-parts.show', $sparePart)
            ->with('success', 'Spare part updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SparePart $sparePart)
    {
        $sparePart->delete();

        return redirect()->route('spare-parts.index')
            ->with('success', 'Spare part deleted successfully.');
    }
}