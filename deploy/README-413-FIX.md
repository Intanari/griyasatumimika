# Mengatasi Error 413 Request Entity Too Large

Error 413 terjadi karena ukuran upload (gambar) melebihi batas server. Ikuti langkah berikut:

## 1. Konfigurasi Nginx

Edit file konfigurasi Nginx (biasanya `/etc/nginx/sites-available/default` atau file site Anda):

```nginx
server {
    # ... konfigurasi lain ...

    # Tambahkan baris ini di dalam block server {}
    client_max_body_size 10M;

    location / {
        # ... 
    }
}
```

Lalu reload Nginx:
```bash
sudo nginx -t
sudo systemctl reload nginx
```

## 2. Konfigurasi PHP (jika menggunakan PHP-FPM)

Edit `php.ini` (lokasi: `/etc/php/8.x/fpm/php.ini` atau `/etc/php.8.x/cli/php.ini`):

```ini
upload_max_filesize = 10M
post_max_size = 12M
```

Restart PHP-FPM:
```bash
sudo systemctl restart php8.2-fpm
```

## 3. File .user.ini (Shared Hosting)

File `public/.user.ini` sudah dibuat. Pastikan file ini ter-upload ke server. Beberapa hosting membaca `.user.ini` untuk override pengaturan PHP.

## 4. Kompresi Otomatis (Sudah Aktif)

Form pelaporan ODGJ sudah dilengkapi **kompresi gambar otomatis** di browser. Gambar > 800 KB akan dikompresi menjadi JPEG sebelum upload, sehingga lebih kecil dan mengurangi risiko error 413.
