<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExaminationHistory extends Model
{
    protected $table = 'examination_histories';

    protected $fillable = [
        'patient_id',
        'tanggal_pemeriksaan',
        'tempat_pemeriksaan',
        'keluhan',
        'hasil_pemeriksaan',
        'tindakan_obat',
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
