<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientSchedule extends Model
{
    protected $table = 'patient_schedules';

    protected $fillable = [
        'patient_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'tempat',
        'jenis',
        'status',
        'catatan',
        'jenis_kegiatan',
        'lokasi',
        'pembimbing',
    ];

    protected $casts = [
        'tanggal'     => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

