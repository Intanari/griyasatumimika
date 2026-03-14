<?php

namespace App\Http\Controllers;

use App\Models\StrukturKepengurusan;
use App\Models\PetugasYayasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (StrukturKepengurusan::count() === 0) {
            Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\StrukturKepengurusanSeeder']);
        }
        $order = ['pembina', 'ketua_yayasan', 'ketua_pengawas', 'sekretaris', 'bendahara', 'pengawas'];
        $kepengurusan = StrukturKepengurusan::all()->sortBy(fn ($m) => array_search($m->role, $order))->values();
        $petugas = PetugasYayasan::orderBy('urutan')->orderBy('nama')->get();
        return view('dashboard.profil-struktur.index', compact('user', 'kepengurusan', 'petugas'));
    }

    public function updateKepengurusan(Request $request)
    {
        $roles = array_keys(StrukturKepengurusan::ROLES);
        $rules = [];
        foreach ($roles as $role) {
            $rules["{$role}_foto"] = 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048';
            $rules["{$role}_nama"] = 'nullable|string|max:255';
            $rules["{$role}_status"] = 'nullable|string|max:255';
            $rules["{$role}_keterangan"] = 'nullable|string';
        }
        $validated = $request->validate($rules);

        foreach ($roles as $role) {
            $model = StrukturKepengurusan::where('role', $role)->first();
            if (!$model) {
                continue;
            }
            $model->nama = $validated["{$role}_nama"] ?? $model->nama;
            $model->status = $validated["{$role}_status"] ?? $model->status;
            $model->keterangan = $validated["{$role}_keterangan"] ?? $model->keterangan;

            if ($request->hasFile("{$role}_foto")) {
                if ($model->foto && Storage::disk('public')->exists($model->foto)) {
                    Storage::disk('public')->delete($model->foto);
                }
                $model->foto = $request->file("{$role}_foto")->store('struktur-kepengurusan', 'public');
            }
            $model->save();
        }

        return redirect()->route('dashboard.profil-struktur.index')
            ->with('success', 'Data kepengurusan yayasan berhasil disimpan.');
    }
}
