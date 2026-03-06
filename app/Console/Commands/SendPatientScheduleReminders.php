<?php

namespace App\Console\Commands;

use App\Mail\PatientScheduleReminderToPembimbing;
use App\Models\PatientSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPatientScheduleReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patient-schedule:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email pengingat jadwal pasien ke pembimbing sesuai waktu pengingat yang dipilih';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = Carbon::now();

        $schedules = PatientSchedule::query()
            ->with(['patient', 'pembimbingUser'])
            ->whereNotNull('pembimbing_id')
            ->whereNotNull('tanggal')
            ->whereNotNull('jam_mulai')
            ->whereNotNull('reminder_before_minutes')
            ->where('status', 'terjadwal')
            ->get();

        foreach ($schedules as $schedule) {
            $startAt = Carbon::parse($schedule->tanggal->format('Y-m-d') . ' ' . $schedule->jam_mulai);
            $reminderAt = $startAt->copy()->subMinutes($schedule->reminder_before_minutes);

            // Pengingat sebelum jadwal (berdasarkan reminder_before_minutes)
            if (
                is_null($schedule->reminder_sent_at)
                && $now->greaterThanOrEqualTo($reminderAt)
                && $schedule->pembimbingUser?->email
            ) {
                try {
                    Mail::to($schedule->pembimbingUser->email)
                        ->send(new PatientScheduleReminderToPembimbing($schedule));

                    $schedule->reminder_sent_at = $now;
                } catch (\Throwable $e) {
                    Log::error('Gagal mengirim pengingat jadwal pasien ke pembimbing: ' . $e->getMessage(), [
                        'schedule_id' => $schedule->id,
                    ]);
                }
            }

            // Pengingat kedua tepat pada waktu mulai jadwal
            if (
                is_null($schedule->start_reminder_sent_at)
                && $now->greaterThanOrEqualTo($startAt)
                && $schedule->pembimbingUser?->email
            ) {
                try {
                    Mail::to($schedule->pembimbingUser->email)
                        ->send(new PatientScheduleReminderToPembimbing($schedule));

                    $schedule->start_reminder_sent_at = $now;
                } catch (\Throwable $e) {
                    Log::error('Gagal mengirim pengingat MULAI jadwal pasien ke pembimbing: ' . $e->getMessage(), [
                        'schedule_id' => $schedule->id,
                    ]);
                }
            }

            if ($schedule->isDirty(['reminder_sent_at', 'start_reminder_sent_at'])) {
                $schedule->save();
            }
        }

        return Command::SUCCESS;
    }
}

