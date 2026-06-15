<?php

namespace App\Services;

use App\Models\Donation;
use GdImage;
use Illuminate\Support\Str;
use RuntimeException;

class DonationQrisCardService
{
    private const FONT_REGULAR = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf';

    private const FONT_BOLD = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf';

    public function buildFilename(Donation $donation): string
    {
        $idPart = Str::slug($donation->order_id, '-');
        $namePart = Str::slug($donation->donor_name, '-');

        return 'pembayaran-qris-' . $idPart . '-' . $namePart . '.png';
    }

    public function generate(Donation $donation, string $qrImageBinary, string $programLabel): string
    {
        if (! extension_loaded('gd')) {
            throw new RuntimeException('Ekstensi PHP GD diperlukan untuk membuat gambar QRIS.');
        }

        $qr = @imagecreatefromstring($qrImageBinary);
        if ($qr === false) {
            throw new RuntimeException('Gambar QR Code tidak valid.');
        }

        $width = 720;
        $height = 1180;
        $canvas = imagecreatetruecolor($width, $height);
        imagealphablending($canvas, true);
        imagesavealpha($canvas, true);

        $this->drawVerticalGradient($canvas, $width, $height, [239, 246, 255], [224, 242, 254], [219, 234, 254]);

        $cardX = 36;
        $cardY = 36;
        $cardW = $width - 72;
        $cardH = $height - 72;
        $this->drawRoundedFilledRect($canvas, $cardX, $cardY, $cardW, $cardH, 24, imagecolorallocate($canvas, 255, 255, 255));

        $headerH = 168;
        $this->drawRoundedTopRect($canvas, $cardX, $cardY, $cardW, $headerH, 24, imagecolorallocate($canvas, 224, 242, 254));

        $white = imagecolorallocate($canvas, 255, 255, 255);
        $headerText = imagecolorallocate($canvas, 30, 64, 175);
        $muted = imagecolorallocate($canvas, 71, 85, 105);
        $dark = imagecolorallocate($canvas, 15, 23, 42);
        $accent = imagecolorallocate($canvas, 96, 165, 250);
        $qrisRed = imagecolorallocate($canvas, 228, 37, 59);

        $centerX = (int) ($width / 2);

        $this->drawTextCentered($canvas, self::FONT_BOLD, 26, $centerX, $cardY + 46, $headerText, 'Griya Satu Mimika');
        $this->drawTextCentered($canvas, self::FONT_REGULAR, 14, $centerX, $cardY + 78, $headerText, 'Sahabat Jiwa — Yayasan Peduli Kasih Mimika');
        $this->drawTextCentered($canvas, self::FONT_BOLD, 13, $centerX, $cardY + 118, $headerText, 'PEMBAYARAN DONASI QRIS');

        $qrSize = 420;
        $qrX = (int) (($width - $qrSize) / 2);
        $qrY = $cardY + $headerH + 28;
        $qrFramePad = 18;

        $qrFrameBg = imagecolorallocate($canvas, 240, 249, 255);
        $this->drawRoundedFilledRect(
            $canvas,
            $qrX - $qrFramePad,
            $qrY - $qrFramePad,
            $qrSize + ($qrFramePad * 2),
            $qrSize + ($qrFramePad * 2),
            20,
            $qrFrameBg,
        );
        imagefilledrectangle($canvas, $qrX - 5, $qrY - 5, $qrX + $qrSize + 4, $qrY + $qrSize + 4, $accent);

        imagecopyresampled($canvas, $qr, $qrX, $qrY, 0, 0, $qrSize, $qrSize, imagesx($qr), imagesy($qr));
        imagedestroy($qr);

        $badgeW = 72;
        $badgeH = 26;
        $badgeX = (int) (($width - $badgeW) / 2);
        $badgeY = $qrY + $qrSize + $qrFramePad + 16;
        imagefilledrectangle($canvas, $badgeX, $badgeY, $badgeX + $badgeW, $badgeY + $badgeH, $qrisRed);
        $this->drawTextCentered($canvas, self::FONT_BOLD, 11, $centerX, $badgeY + 18, $white, 'QRIS');

        $this->drawTextCentered($canvas, self::FONT_REGULAR, 12, $centerX, $badgeY + 44, $muted, 'Scan untuk menyelesaikan pembayaran');

        $detailsY = $badgeY + 78;
        $labelX = $cardX + 40;
        $valueX = $cardX + 170;
        $lineH = 34;

        $rows = [
            ['Donatur', $donation->donor_name],
            ['Email', $donation->donor_email],
            ['Program', $programLabel],
            ['Nominal', $donation->formatted_amount],
            ['ID Transaksi', $donation->order_id],
            ['Tanggal', $donation->created_at?->translatedFormat('d M Y H:i') ?? '-'],
        ];

        foreach ($rows as $index => [$label, $value]) {
            $y = $detailsY + ($index * $lineH);
            imageline($canvas, $cardX + 28, $y - 8, $cardX + $cardW - 28, $y - 8, imagecolorallocate($canvas, 219, 234, 254));
            $this->drawText($canvas, self::FONT_REGULAR, 11, $labelX, $y + 10, $muted, $label . ':');
            $this->drawWrappedText($canvas, self::FONT_BOLD, 11, $valueX, $y + 10, $dark, (string) $value, $cardX + $cardW - 40);
        }

        $footerY = $cardY + $cardH - 42;
        $this->drawTextCentered($canvas, self::FONT_REGULAR, 11, $centerX, $footerY, $muted, config('app.main_domain', 'griyasatumimika.web.id'));
        $this->drawTextCentered($canvas, self::FONT_REGULAR, 10, $centerX, $footerY + 20, $muted, 'Terima kasih atas kebaikan hati Anda');

        ob_start();
        imagepng($canvas);
        $png = ob_get_clean();
        imagedestroy($canvas);

        if ($png === false) {
            throw new RuntimeException('Gagal membuat gambar QRIS.');
        }

        return $png;
    }

    private function drawVerticalGradient(GdImage $img, int $w, int $h, array $c1, array $c2, array $c3): void
    {
        for ($y = 0; $y < $h; $y++) {
            $ratio = $h <= 1 ? 0 : $y / ($h - 1);
            $ratio = min(1, max(0, $ratio));

            if ($ratio < 0.5) {
                $local = $ratio * 2;
                $r = (int) ($c1[0] + ($c2[0] - $c1[0]) * $local);
                $g = (int) ($c1[1] + ($c2[1] - $c1[1]) * $local);
                $b = (int) ($c1[2] + ($c2[2] - $c1[2]) * $local);
            } else {
                $local = ($ratio - 0.5) * 2;
                $r = (int) ($c2[0] + ($c3[0] - $c2[0]) * $local);
                $g = (int) ($c2[1] + ($c3[1] - $c2[1]) * $local);
                $b = (int) ($c2[2] + ($c3[2] - $c2[2]) * $local);
            }

            $color = imagecolorallocate($img, $r, $g, $b);
            imageline($img, 0, $y, $w, $y, $color);
        }
    }

    private function drawRoundedFilledRect(GdImage $img, int $x, int $y, int $w, int $h, int $r, int $color): void
    {
        imagefilledrectangle($img, $x + $r, $y, $x + $w - $r, $y + $h, $color);
        imagefilledrectangle($img, $x, $y + $r, $x + $w, $y + $h - $r, $color);
        imagefilledellipse($img, $x + $r, $y + $r, $r * 2, $r * 2, $color);
        imagefilledellipse($img, $x + $w - $r, $y + $r, $r * 2, $r * 2, $color);
        imagefilledellipse($img, $x + $r, $y + $h - $r, $r * 2, $r * 2, $color);
        imagefilledellipse($img, $x + $w - $r, $y + $h - $r, $r * 2, $r * 2, $color);
    }

    private function drawRoundedTopRect(GdImage $img, int $x, int $y, int $w, int $h, int $r, int $color): void
    {
        imagefilledrectangle($img, $x, $y + $r, $x + $w, $y + $h, $color);
        imagefilledrectangle($img, $x + $r, $y, $x + $w - $r, $y + $r, $color);
        imagefilledellipse($img, $x + $r, $y + $r, $r * 2, $r * 2, $color);
        imagefilledellipse($img, $x + $w - $r, $y + $r, $r * 2, $r * 2, $color);
    }

    private function drawText(GdImage $img, string $font, int $size, int $x, int $y, int $color, string $text): void
    {
        imagettftext($img, $size, 0, $x, $y, $color, $font, $text);
    }

    private function drawTextCentered(GdImage $img, string $font, int $size, int $centerX, int $y, int $color, string $text): void
    {
        $box = imagettfbbox($size, 0, $font, $text);
        $textWidth = abs($box[2] - $box[0]);
        $x = (int) ($centerX - ($textWidth / 2));
        imagettftext($img, $size, 0, $x, $y, $color, $font, $text);
    }

    private function drawWrappedText(GdImage $img, string $font, int $size, int $x, int $y, int $color, string $text, int $maxX): void
    {
        $words = preg_split('/\s+/', trim($text)) ?: [];
        $line = '';
        $lineY = $y;

        foreach ($words as $word) {
            $candidate = $line === '' ? $word : $line . ' ' . $word;
            $box = imagettfbbox($size, 0, $font, $candidate);
            $lineWidth = abs($box[2] - $box[0]);

            if ($lineWidth > ($maxX - $x) && $line !== '') {
                imagettftext($img, $size, 0, $x, $lineY, $color, $font, $line);
                $line = $word;
                $lineY += $size + 8;
            } else {
                $line = $candidate;
            }
        }

        if ($line !== '') {
            imagettftext($img, $size, 0, $x, $lineY, $color, $font, $line);
        }
    }
}
