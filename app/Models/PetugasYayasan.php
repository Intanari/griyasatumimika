<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PetugasYayasan extends Model
{
    protected $table = 'petugas_yayasan';

    protected $fillable = ['foto', 'nama', 'status', 'keterangan', 'urutan'];

    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto) {
            return null;
        }
        return Storage::disk('public')->exists($this->foto)
            ? asset('storage/' . $this->foto)
            : null;
    }

    public function getAvatarInitialsAttribute(): string
    {
        if ($this->nama) {
            $words = preg_split('/\s+/', trim($this->nama), 2);
            if (count($words) >= 2) {
                return strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
            }
            return strtoupper(mb_substr($this->nama, 0, 2));
        }
        return 'PY';
    }
}
