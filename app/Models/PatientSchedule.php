<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PatientSchedule extends Model
{
    protected $table = 'patient_schedules';

    protected $fillable = [
        'patient_id',
        'pembimbing_id',
        'reminder_before_minutes',
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
        'tanggal'                 => 'date',
        'reminder_before_minutes' => 'integer',
        'reminder_sent_at'        => 'datetime',
        'start_reminder_sent_at'  => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

     public function pembimbingUser()
     {
         return $this->belongsTo(User::class, 'pembimbing_id');
     }
}

