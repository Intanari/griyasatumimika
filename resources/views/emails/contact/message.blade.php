<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Kontak Baru</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1e293b; line-height: 1.6;">
    <h2 style="color: #2563eb; margin-bottom: 16px;">Pesan Baru dari Halaman Kontak</h2>
    <p><strong>Nama:</strong> {{ $data['nama'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    @if(!empty($data['telepon']))
        <p><strong>WhatsApp:</strong> {{ $data['telepon'] }}</p>
    @endif
    @if(!empty($data['subjek']))
        <p><strong>Subjek:</strong> {{ $data['subjek'] }}</p>
    @endif
    <p><strong>Pesan:</strong></p>
    <p style="white-space: pre-wrap; background: #f8fafc; padding: 12px; border-radius: 8px;">{{ $data['pesan'] }}</p>
</body>
</html>
