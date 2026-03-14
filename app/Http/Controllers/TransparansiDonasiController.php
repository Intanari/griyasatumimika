<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationExpense;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TransparansiDonasiController extends Controller
{
    public function index()
    {
        $donationsAll = Donation::all();
        $expensesAll = DonationExpense::all();

        $totalDonasi = $donationsAll->count();
        $berhasil = $donationsAll->where('status', 'paid')->count();
        $pending = $donationsAll->whereIn('status', ['pending', 'expired'])->count();
        $gagal = $donationsAll->where('status', 'failed')->count();
        $danaTerkumpul = $donationsAll->where('status', 'paid')->sum('amount');
        $pengeluaran = $expensesAll->sum('jumlah');
        $sisaDonasi = $danaTerkumpul - $pengeluaran;

        $donations = Donation::orderByDesc('created_at')->paginate(7, ['*'], 'donations_page');
        $expenses = DonationExpense::orderByDesc('tanggal_pengeluaran')->orderByDesc('created_at')->paginate(7, ['*'], 'expenses_page');

        return view('public.transparan.index', compact(
            'donations',
            'expenses',
            'totalDonasi',
            'berhasil',
            'pending',
            'gagal',
            'danaTerkumpul',
            'pengeluaran',
            'sisaDonasi'
        ));
    }

    public function pdfDonations()
    {
        $donations = Donation::orderByDesc('created_at')->get();
        $pdf = Pdf::loadView('public.transparan.pdf-donations', compact('donations'))
            ->setPaper('a4', 'landscape');
        $filename = 'laporan-donasi-' . now()->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }

    public function pdfExpenses()
    {
        $expenses = DonationExpense::orderByDesc('tanggal_pengeluaran')->orderByDesc('created_at')->get();
        $pdf = Pdf::loadView('public.transparan.pdf-expenses', compact('expenses'))
            ->setPaper('a4', 'portrait');
        $filename = 'laporan-pengeluaran-donasi-' . now()->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }
}
