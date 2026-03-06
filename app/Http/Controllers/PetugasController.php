<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = User::query()
            ->whereIn('role', ['admin', 'petugas_rehabilitasi']);

        if ($search = $request->string('search')->trim()) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status_kerja')) {
            $query->where('status_kerja', $status);
        }

        $petugas = $query->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        // Statistik sederhana
        $stats = [
            'total'    => (clone $query)->count(),
            'aktif'    => (clone $query)->where('status_kerja', 'aktif')->count(),
            'cuti'     => (clone $query)->where('status_kerja', 'cuti')->count(),
            'nonaktif' => (clone $query)->where('status_kerja', 'nonaktif')->count(),
        ];

        return view('dashboard.petugas.index', compact('user', 'petugas', 'stats'));
    }

    public function show(User $petuga)
    {
        $user = Auth::user();
        return view('dashboard.petugas.show', compact('user', 'petuga'));
    }

    // Sementara, form tambah/edit belum dipulihkan sepenuhnya.
    // Agar tidak error 500, kita tampilkan 404 bila diakses.

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function edit(User $petuga)
    {
        abort(404);
    }

    public function update(Request $request, User $petuga)
    {
        abort(404);
    }

    public function destroy(User $petuga)
    {
        abort(404);
    }

    // Endpoint export lama belum dipulihkan; untuk sementara nonaktifkan.
    public function exportExcel(Request $request)
    {
        abort(404);
    }

    public function exportPdf(Request $request)
    {
        abort(404);
    }
}

