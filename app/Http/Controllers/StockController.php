<?php

namespace App\Http\Controllers;

use App\Mail\StockAlertToPetugas;
use App\Models\InventoryItem;
use App\Models\StockExpense;
use App\Models\StockSupply;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StockController extends Controller
{
    /**
     * Dashboard manajemen stok: card sisa, tabel persediaan, tabel pengeluaran.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $supplies = StockSupply::orderByDesc('created_at')->get();
        $expenses = StockExpense::orderByDesc('created_at')->get();

        // Card sisa: per nama = total persediaan - total pengeluaran
        $totalByNamaSupply = $supplies->groupBy('nama')->map(fn ($rows) => $rows->sum('jumlah'));
        $totalByNamaExpense = $expenses->groupBy('nama')->map(fn ($rows) => $rows->sum('jumlah'));
        $allNames = $totalByNamaSupply->keys()->merge($totalByNamaExpense->keys())->unique()->sort()->values();
        $cardSisa = $allNames->map(fn ($nama) => [
            'nama' => $nama,
            'sisa' => ($totalByNamaSupply[$nama] ?? 0) - ($totalByNamaExpense[$nama] ?? 0),
        ])->values();

        return view('dashboard.stock.index', compact('user', 'supplies', 'expenses', 'cardSisa'));
    }

    public function createSupply()
    {
        $user = Auth::user();
        $existingNames = StockSupply::select('nama')->distinct()->pluck('nama')->merge(
            StockExpense::select('nama')->distinct()->pluck('nama')
        )->unique()->sort()->values();
        return view('dashboard.stock.create-supply', compact('user', 'existingNames'));
    }

    public function storeSupply(Request $request)
    {
        $valid = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'nullable|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);
        $valid['jumlah'] = (int) $valid['jumlah'];
        $valid['gambar'] = $request->hasFile('gambar') ? $request->file('gambar')->store('stock-supplies', 'public') : null;
        StockSupply::create($valid);
        return redirect()->route('dashboard.stock.index')->with('success', 'Persediaan stok barang berhasil ditambah.');
    }

    public function showSupply(StockSupply $stock_supply)
    {
        $user = Auth::user();
        return view('dashboard.stock.show-supply', compact('user', 'stock_supply'));
    }

    public function editSupply(StockSupply $stock_supply)
    {
        $user = Auth::user();
        $existingNames = StockSupply::select('nama')->distinct()->pluck('nama')->merge(
            StockExpense::select('nama')->distinct()->pluck('nama')
        )->unique()->sort()->values();
        return view('dashboard.stock.edit-supply', compact('user', 'stock_supply', 'existingNames'));
    }

    public function updateSupply(Request $request, StockSupply $stock_supply)
    {
        $valid = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'nullable|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);
        $stock_supply->nama = $valid['nama'];
        $stock_supply->jumlah = (int) $valid['jumlah'];
        $stock_supply->harga = $valid['harga'] ?? null;
        if ($request->hasFile('gambar')) {
            if ($stock_supply->gambar) {
                Storage::disk('public')->delete($stock_supply->gambar);
            }
            $stock_supply->gambar = $request->file('gambar')->store('stock-supplies', 'public');
        }
        $stock_supply->save();
        return redirect()->route('dashboard.stock.index')->with('success', 'Persediaan stok berhasil diperbarui.');
    }

    public function destroySupply(StockSupply $stock_supply)
    {
        if ($stock_supply->gambar) {
            Storage::disk('public')->delete($stock_supply->gambar);
        }
        $stock_supply->delete();
        return redirect()->route('dashboard.stock.index')->with('success', 'Persediaan stok berhasil dihapus.');
    }

    public function createExpense()
    {
        $user = Auth::user();
        $supplyNames = StockSupply::select('nama')->distinct()->orderBy('nama')->pluck('nama');
        return view('dashboard.stock.create-expense', compact('user', 'supplyNames'));
    }

    public function storeExpense(Request $request)
    {
        $supplyNamas = StockSupply::pluck('nama')->toArray();
        $valid = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::in($supplyNamas)],
            'jumlah' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'nama.in' => 'Nama barang harus dipilih dari daftar stok barang (tambah stok barang).',
        ]);
        $valid['jumlah'] = (int) $valid['jumlah'];
        $valid['gambar'] = $request->hasFile('gambar') ? $request->file('gambar')->store('stock-expenses', 'public') : null;
        StockExpense::create($valid);
        return redirect()->route('dashboard.stock.index')->with('success', 'Pengeluaran stok barang berhasil ditambah.');
    }

    public function showExpense(StockExpense $stock_expense)
    {
        $user = Auth::user();
        return view('dashboard.stock.show-expense', compact('user', 'stock_expense'));
    }

    public function editExpense(StockExpense $stock_expense)
    {
        $user = Auth::user();
        $supplyNames = StockSupply::select('nama')->distinct()->orderBy('nama')->pluck('nama');
        if ($stock_expense->nama && !$supplyNames->contains($stock_expense->nama)) {
            $supplyNames = $supplyNames->push($stock_expense->nama)->sort()->values();
        }
        return view('dashboard.stock.edit-expense', compact('user', 'stock_expense', 'supplyNames'));
    }

    public function updateExpense(Request $request, StockExpense $stock_expense)
    {
        $supplyNamas = StockSupply::pluck('nama')->toArray();
        $allowedNamas = array_unique(array_merge($supplyNamas, [$stock_expense->nama]));
        $valid = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::in($allowedNamas)],
            'jumlah' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'nama.in' => 'Nama barang harus dipilih dari daftar stok barang (tambah stok barang).',
        ]);
        $stock_expense->nama = $valid['nama'];
        $stock_expense->jumlah = (int) $valid['jumlah'];
        if ($request->hasFile('gambar')) {
            if ($stock_expense->gambar) {
                Storage::disk('public')->delete($stock_expense->gambar);
            }
            $stock_expense->gambar = $request->file('gambar')->store('stock-expenses', 'public');
        }
        $stock_expense->save();
        return redirect()->route('dashboard.stock.index')->with('success', 'Pengeluaran stok berhasil diperbarui.');
    }

    public function destroyExpense(StockExpense $stock_expense)
    {
        if ($stock_expense->gambar) {
            Storage::disk('public')->delete($stock_expense->gambar);
        }
        $stock_expense->delete();
        return redirect()->route('dashboard.stock.index')->with('success', 'Pengeluaran stok berhasil dihapus.');
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
