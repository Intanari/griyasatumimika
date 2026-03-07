<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientActivity extends Model
{
    protected $table = 'patient_activities';

    protected $fillable = [
        'patient_id',
        'tanggal',
        'jenis_aktivitas',
        'deskripsi',
        'image',
        'batch_uuid',
        'hasil_evaluasi',
        'waktu_mulai',
        'waktu_selesai',
        'durasi_menit',
        'tempat',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Get image paths as array (supports old single path or new JSON array).
     */
    public function getImagesArrayAttribute(): array
    {
        if (!$this->image) {
            return [];
        }
        $decoded = json_decode($this->image, true);
        if (is_array($decoded)) {
            return $decoded;
        }
        return [$this->image];
    }

    public const JENIS_AKTIVITAS = [
        'terapi'       => 'Terapi',
        'senam'        => 'Senam',
        'keterampilan' => 'Keterampilan',
        'ibadah'       => 'Ibadah',
        'rekreasi'     => 'Rekreasi',
        'lainnya'      => 'Lainnya',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getJenisAktivitasLabelAttribute(): string
    {
        return self::JENIS_AKTIVITAS[$this->jenis_aktivitas] ?? $this->jenis_aktivitas;
    }

    public function getImageUrlAttribute(): ?string
    {
        $arr = $this->images_array;
        return $arr[0] ?? null ? \Illuminate\Support\Facades\Storage::url($arr[0]) : null;
    }

    public function getImageUrlsAttribute(): array
    {
        return array_map(
            fn ($path) => \Illuminate\Support\Facades\Storage::url($path),
            $this->images_array
        );
    }
}
