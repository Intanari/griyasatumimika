<?php

namespace App\Http\Controllers;

use App\Mail\StockAlertToPetugas;
use App\Models\InventoryItem;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StockController extends Controller
{
    /**
     * Dashboard manajemen stok.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = InventoryItem::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('status')) {
            if ($request->status === 'habis') {
                $query->where('quantity', '<=', 0);
            } elseif ($request->status === 'low') {
                $query->whereColumn('quantity', '<=', 'min_stock')->where('quantity', '>', 0);
            } elseif ($request->status === 'aman') {
                $query->whereColumn('quantity', '>', 'min_stock');
            }
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('supplier')) {
            $query->where('supplier', 'like', '%' . $request->supplier . '%');
        }

        $items = $query->orderBy('name')->get();

        $totalItems = InventoryItem::count();
        $totalQuantity = InventoryItem::sum('quantity');
        $outOfStock = InventoryItem::where('quantity', '<=', 0)->count();
        $lowStock = InventoryItem::whereColumn('quantity', '<=', 'min_stock')->where('quantity', '>', 0)->count();
        $totalValue = InventoryItem::selectRaw('SUM(quantity * COALESCE(unit_price, 0)) as total')->value('total') ?? 0;

        $lowStockItems = InventoryItem::whereColumn('quantity', '<=', 'min_stock')->where('quantity', '>', 0)->orderBy('quantity')->get();
        $expiredItems = InventoryItem::whereNotNull('expiry_date')->where('expiry_date', '<', now())->orderBy('expiry_date')->get();
        $expiringSoon = InventoryItem::whereNotNull('expiry_date')->where('expiry_date', '>=', now())->where('expiry_date', '<=', now()->addDays(30))->orderBy('expiry_date')->get();

        $recommendRestock = InventoryItem::whereColumn('quantity', '<=', 'min_stock')->orderBy('quantity')->get();

        $transactions = StockTransaction::with('item')->orderByDesc('created_at')->limit(50)->get();

        $chartByCategory = InventoryItem::select('category', DB::raw('COUNT(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();
        $chartCategoryLabels = $chartByCategory->map(fn ($r) => InventoryItem::categories()[$r->category] ?? $r->category)->values()->toArray();
        $chartCategoryData = $chartByCategory->pluck('total')->values()->toArray();

        $usageWeeks = collect(range(5, 0))->map(fn ($i) => now()->subWeeks($i));
        $usageOut = [];
        foreach ($usageWeeks as $weekStart) {
            $usageOut[] = StockTransaction::where('type', 'out')
                ->whereBetween('created_at', [$weekStart->startOfWeek(), $weekStart->copy()->endOfWeek()])
                ->sum('quantity');
        }
        $chartUsageLabels = $usageWeeks->map(fn ($d) => 'Minggu ' . $d->weekOfYear . ' ' . $d->format('M'))->values()->toArray();

        $stockStatusCounts = [
            'aman' => InventoryItem::whereColumn('quantity', '>', 'min_stock')->count(),
            'low' => $lowStock,
            'habis' => $outOfStock,
        ];

        $chartStockPie = [
            'labels' => ['Aman', 'Hampir Habis', 'Habis'],
            'data' => [$stockStatusCounts['aman'], $stockStatusCounts['low'], $stockStatusCounts['habis']],
        ];

        return view('dashboard.stock.index', compact(
            'user',
            'items',
            'totalItems',
            'totalQuantity',
            'outOfStock',
            'lowStock',
            'totalValue',
            'lowStockItems',
            'expiredItems',
            'expiringSoon',
            'recommendRestock',
            'transactions',
            'chartCategoryLabels',
            'chartCategoryData',
            'chartUsageLabels',
            'usageOut',
            'chartStockPie'
        ));
    }

    /**
     * Simpan barang baru atau restock.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $isRestock = $request->boolean('is_restock');
        $rules = [
            'quantity' => $isRestock ? 'required|integer|min:1' : 'required|integer|min:0',
            'unit' => 'nullable|string|max:20',
            'min_stock' => 'nullable|integer|min:0',
            'date_in' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'supplier' => 'nullable|string|max:255',
            'unit_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'is_restock' => 'nullable|boolean',
            'item_id' => 'nullable|exists:inventory_items,id',
        ];
        if (! $isRestock) {
            $rules['name'] = 'required|string|max:255';
            $rules['category'] = 'required|string|in:' . implode(',', array_keys(InventoryItem::categories()));
        } else {
            $rules['item_id'] = 'required|exists:inventory_items,id';
        }
        $valid = $request->validate($rules);

        if ($isRestock && ! empty($valid['item_id'])) {
            $item = InventoryItem::findOrFail($valid['item_id']);
            $item->increment('quantity', $valid['quantity']);
            $item->update([
                'date_in' => $valid['date_in'] ?? $item->date_in,
                'supplier' => $valid['supplier'] ?? $item->supplier,
            ]);
            StockTransaction::create([
                'inventory_item_id' => $item->id,
                'type' => 'in',
                'quantity' => $valid['quantity'],
                'staff_name' => $user->name,
                'user_id' => $user->id,
                'notes' => $valid['notes'] ?? 'Restock',
            ]);
            return redirect()->route('dashboard.stock.index')->with('success', 'Stok berhasil ditambah (restock).');
        }

        $valid['unit'] = $valid['unit'] ?? 'pcs';
        $valid['min_stock'] = $valid['min_stock'] ?? 5;
        $item = InventoryItem::create($valid);
        StockTransaction::create([
            'inventory_item_id' => $item->id,
            'type' => 'in',
            'quantity' => $item->quantity,
            'staff_name' => $user->name,
            'user_id' => $user->id,
            'notes' => 'Stok awal',
        ]);
        return redirect()->route('dashboard.stock.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Update barang.
     */
    public function update(Request $request, InventoryItem $stock)
    {
        $valid = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:' . implode(',', array_keys(InventoryItem::categories())),
            'unit' => 'nullable|string|max:20',
            'min_stock' => 'nullable|integer|min:0',
            'date_in' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'supplier' => 'nullable|string|max:255',
            'unit_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
        $valid['unit'] = $valid['unit'] ?? 'pcs';
        $valid['min_stock'] = $valid['min_stock'] ?? 5;
        $stock->update($valid);
        return redirect()->route('dashboard.stock.index')->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Barang keluar (pemakaian).
     */
    public function stockOut(Request $request)
    {
        $user = Auth::user();
        $valid = $request->validate([
            'item_id' => 'required|exists:inventory_items,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);
        $item = InventoryItem::findOrFail($valid['item_id']);
        if ($item->quantity < $valid['quantity']) {
            return redirect()->route('dashboard.stock.index')->with('error', 'Jumlah keluar melebihi stok tersedia.');
        }
        $item->decrement('quantity', $valid['quantity']);
        StockTransaction::create([
            'inventory_item_id' => $item->id,
            'type' => 'out',
            'quantity' => $valid['quantity'],
            'staff_name' => $user->name,
            'user_id' => $user->id,
            'notes' => $valid['notes'] ?? 'Pemakaian',
        ]);

        $item->refresh();
        $alerts = [];
        if ($item->quantity <= 0) {
            $alerts[] = ['item' => $item, 'status' => 'habis'];
        } elseif ($item->quantity <= $item->min_stock) {
            $alerts[] = ['item' => $item, 'status' => 'hampir_habis'];
        }
        if (! empty($alerts)) {
            $this->sendStockAlertToPetugas($alerts);
        }

        return redirect()->route('dashboard.stock.index')->with('success', 'Stok keluar berhasil dicatat.');
    }

    /**
     * Kirim notifikasi stok (habis/hampir habis) ke email petugas.
     *
     * @param  array<array{item: InventoryItem, status: 'habis'|'hampir_habis'}>  $alerts
     */
    private function sendStockAlertToPetugas(array $alerts): void
    {
        try {
            $emails = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_MANAGER, User::ROLE_PETUGAS])
                ->where(function ($q) {
                    $q->where('is_active', true)->orWhereNull('is_active');
                })
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->unique()
                ->values()
                ->toArray();

            if (! empty($emails)) {
                Mail::to($emails)->send(new StockAlertToPetugas($alerts));
            }
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim notifikasi stok ke petugas: ' . $e->getMessage());
        }
    }

    /**
     * Hapus barang (soft / hard delete).
     */
    public function destroy(InventoryItem $stock)
    {
        $stock->delete();
        return redirect()->route('dashboard.stock.index')->with('success', 'Barang berhasil dihapus.');
    }

    /**
     * Export daftar barang ke CSV.
     */
    public function exportCsv(): StreamedResponse
    {
        $items = InventoryItem::orderBy('category')->orderBy('name')->get();
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="stok-barang-' . now()->format('Y-m-d') . '.csv"',
        ];
        $callback = function () use ($items) {
            $stream = fopen('php://output', 'w');
            fputcsv($stream, ['Nama', 'Kategori', 'Jumlah', 'Satuan', 'Stok Min', 'Tanggal Masuk', 'Kadaluarsa', 'Supplier', 'Harga/Unit', 'Status'], ';');
            foreach ($items as $item) {
                fputcsv($stream, [
                    $item->name,
                    $item->category_label,
                    $item->quantity,
                    $item->unit,
                    $item->min_stock,
                    $item->date_in?->format('d/m/Y'),
                    $item->expiry_date?->format('d/m/Y'),
                    $item->supplier,
                    $item->unit_price,
                    $item->stock_status,
                ], ';');
            }
            fclose($stream);
        };
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Data item untuk modal detail / API.
     */
    public function show(InventoryItem $stock)
    {
        $stock->load('transactions.user');
        $transactions = $stock->transactions()
            ->orderByDesc('created_at')
            ->limit(20)
            ->get()
            ->map(fn ($t) => [
                'created_at' => $t->created_at->format('d/m/Y H:i'),
                'type' => $t->type,
                'quantity' => $t->quantity,
                'staff_name' => $t->staff_name ?? $t->user?->name,
                'notes' => $t->notes,
            ]);
        return response()->json([
            'item' => [
                'id' => $stock->id,
                'name' => $stock->name,
                'category' => $stock->category,
                'category_label' => $stock->category_label,
                'quantity' => $stock->quantity,
                'unit' => $stock->unit,
                'min_stock' => $stock->min_stock,
                'date_in' => $stock->date_in?->format('d/m/Y'),
                'expiry_date' => $stock->expiry_date?->format('d/m/Y'),
                'supplier' => $stock->supplier,
                'unit_price' => $stock->unit_price,
                'notes' => $stock->notes,
            ],
            'transactions' => $transactions,
        ]);
    }
}
