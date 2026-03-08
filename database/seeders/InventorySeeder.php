<?php

namespace Database\Seeders;

use App\Models\InventoryItem;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['name' => 'Beras 5kg', 'category' => 'makanan', 'quantity' => 50, 'unit' => 'karung', 'min_stock' => 10, 'supplier' => 'Toko Sejahtera', 'unit_price' => 65000],
            ['name' => 'Minyak Goreng 2L', 'category' => 'makanan', 'quantity' => 30, 'unit' => 'liter', 'min_stock' => 10, 'supplier' => 'Toko Sejahtera', 'unit_price' => 28000],
            ['name' => 'Paracetamol 500mg', 'category' => 'obat', 'quantity' => 5, 'unit' => 'strip', 'min_stock' => 20, 'supplier' => 'Apotek Sehat', 'unit_price' => 5000],
            ['name' => 'Vitamin C', 'category' => 'obat', 'quantity' => 15, 'unit' => 'botol', 'min_stock' => 5, 'supplier' => 'Apotek Sehat', 'unit_price' => 25000],
            ['name' => 'Tensimeter Digital', 'category' => 'alat_kesehatan', 'quantity' => 3, 'unit' => 'pcs', 'min_stock' => 2, 'supplier' => 'Alkes Medika', 'unit_price' => 150000],
            ['name' => 'Termometer', 'category' => 'alat_kesehatan', 'quantity' => 0, 'unit' => 'pcs', 'min_stock' => 2, 'supplier' => 'Alkes Medika', 'unit_price' => 45000],
            ['name' => 'Sabun Mandi', 'category' => 'kebersihan', 'quantity' => 8, 'unit' => 'lusin', 'min_stock' => 10, 'supplier' => 'Toko Harapan', 'unit_price' => 12000],
            ['name' => 'Karbol', 'category' => 'kebersihan', 'quantity' => 4, 'unit' => 'liter', 'min_stock' => 5, 'supplier' => 'Toko Harapan', 'unit_price' => 18000],
            ['name' => 'Kertas A4', 'category' => 'perlengkapan', 'quantity' => 25, 'unit' => 'rim', 'min_stock' => 5, 'supplier' => 'Toko ATK', 'unit_price' => 45000],
        ];

        $user = User::first();
        $dateIn = now()->subMonths(2);

        foreach ($items as $i => $data) {
            $data['date_in'] = $dateIn;
            $data['expiry_date'] = in_array($data['category'], ['obat', 'makanan'], true)
                ? now()->addMonths(rand(1, 12))
                : null;
            $item = InventoryItem::create($data);
            StockTransaction::create([
                'inventory_item_id' => $item->id,
                'type' => 'in',
                'quantity' => $item->quantity,
                'staff_name' => $user?->name ?? 'Admin',
                'user_id' => $user?->id,
                'notes' => 'Stok awal',
            ]);
        }
    }
}
