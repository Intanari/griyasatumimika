# Panduan Setup Laravel + Nginx + SSL di Ubuntu

Dokumentasi lengkap langkah-langkah instalasi dan konfigurasi Laravel dengan Nginx dan SSL Let's Encrypt.

---

## Spesifikasi Sistem

- **OS:** Ubuntu 24.04 (Noble)
- **PHP:** 8.3.6
- **Laravel:** 12.x
- **Web Server:** Nginx
- **Database:** SQLite
- **SSL:** Let's Encrypt (Certbot)
- **Domain:** griyasatumimika.web.id

---

## Langkah 1 — Update Package List

```bash
sudo apt-get update -y
```

---

## Langkah 2 — Install PHP 8.3 dan Ekstensi Laravel

```bash
sudo apt-get install -y \
  php8.3 php8.3-cli php8.3-fpm \
  php8.3-mbstring php8.3-xml php8.3-bcmath \
  php8.3-curl php8.3-zip php8.3-mysql \
  php8.3-sqlite3 php8.3-intl \
  unzip curl git
```

**Ekstensi yang diinstall untuk Laravel:**

| Ekstensi | Kegunaan |
|----------|----------|
| mbstring | Manipulasi string multibyte |
| xml | Parsing XML |
| bcmath | Kalkulasi angka presisi tinggi |
| curl | HTTP requests |
| zip | Kompresi file |
| pdo_mysql | Koneksi database MySQL |
| pdo_sqlite | Koneksi database SQLite |
| intl | Internasionalisasi |

---

## Langkah 3 — Install Composer

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

---

## Langkah 4 — Install Node.js dan npm

```bash
# Tambah repository Node.js 22 LTS
curl -fsSL https://deb.nodesource.com/setup_22.x | sudo -E bash -

# Install Node.js
sudo apt-get install -y nodejs

# Verifikasi
node --version
npm --version
```

---

## Langkah 5 — Buat Project Laravel

```bash
cd /home/ubuntu
composer create-project laravel/laravel my-laravel-app
cd my-laravel-app
```

Perintah ini secara otomatis akan:
- Mengunduh Laravel versi terbaru
- Membuat file `.env`
- Generate `APP_KEY`
- Membuat file `database/database.sqlite`
- Menjalankan migrasi awal (users, cache, jobs table)

---

## Langkah 6 — Install Dependensi npm

```bash
cd /home/ubuntu/my-laravel-app

# Ganti registry ke npm official (jika ada masalah mirror)
npm config set registry https://registry.npmjs.org

npm install --legacy-peer-deps
```

---

## Langkah 7 — Install dan Konfigurasi Nginx

### Install Nginx

```bash
sudo apt-get install -y nginx
sudo systemctl start nginx
sudo systemctl enable nginx
```

### Buat Konfigurasi Nginx untuk Laravel

```bash
sudo nano /etc/nginx/sites-available/griyasatumimika.web.id
```

Isi konfigurasi:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name griyasatumimika.web.id www.griyasatumimika.web.id;

    root /home/ubuntu/my-laravel-app/public;
    index index.php index.html;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Aktifkan Site dan Reload Nginx

```bash
sudo ln -sf /etc/nginx/sites-available/griyasatumimika.web.id /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl reload nginx
```

---

## Langkah 8 — Start PHP-FPM

```bash
sudo systemctl start php8.3-fpm
sudo systemctl enable php8.3-fpm
```

---

## Langkah 9 — Set Permission Laravel

```bash
# Permission storage dan bootstrap/cache
sudo chown -R www-data:www-data /home/ubuntu/my-laravel-app/storage
sudo chown -R www-data:www-data /home/ubuntu/my-laravel-app/bootstrap/cache

# Permission database SQLite
sudo chown -R www-data:www-data /home/ubuntu/my-laravel-app/database
sudo chmod -R 775 /home/ubuntu/my-laravel-app/database

# Akses folder public
sudo chmod -R 755 /home/ubuntu
```

> **Penting:** Jika tidak set permission dengan benar, akan muncul error:
> `SQLSTATE[HY000]: General error: 8 attempt to write to a readonly database`

---

## Langkah 10 — Install SSL dengan Certbot (Let's Encrypt)

### Install Certbot

```bash
sudo apt-get install -y certbot python3-certbot-nginx
```

### Generate SSL Certificate

```bash
sudo certbot --nginx \
  -d griyasatumimika.web.id \
  --non-interactive \
  --agree-tos \
  --email admin@griyasatumimika.web.id \
  --redirect
```

Certbot secara otomatis akan:
- Mengambil SSL certificate dari Let's Encrypt
- Mengupdate konfigurasi Nginx dengan SSL
- Mengaktifkan redirect HTTP → HTTPS
- Menjadwalkan auto-renewal certificate

### Verifikasi Auto-Renewal

```bash
sudo certbot renew --dry-run
```

---

## Verifikasi Akhir

```bash
# Cek status Nginx
sudo systemctl status nginx

# Cek status PHP-FPM
sudo systemctl status php8.3-fpm

# Cek versi semua tools
php --version
composer --version
node --version
npm --version

# Test website
curl -s -o /dev/null -w "%{http_code}" https://griyasatumimika.web.id
# Output: 200
```

---

## Informasi Certificate SSL

| Item | Detail |
|------|--------|
| Certificate | `/etc/letsencrypt/live/griyasatumimika.web.id/fullchain.pem` |
| Private Key | `/etc/letsencrypt/live/griyasatumimika.web.id/privkey.pem` |
| Berlaku hingga | 31 Mei 2026 |
| Auto-renewal | Aktif (otomatis via cron) |

---

## Struktur Project Laravel

```
my-laravel-app/
├── app/
│   ├── Http/
│   │   └── Controllers/    # Controllers
│   └── Models/             # Eloquent Models
├── bootstrap/
│   └── cache/              # Cache framework (www-data)
├── config/                 # Konfigurasi aplikasi
├── database/
│   ├── database.sqlite     # File database SQLite (www-data)
│   ├── migrations/         # Migrasi database
│   └── seeders/            # Seeder database
├── public/                 # Entry point web server (document root)
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # Stylesheet
│   └── js/                 # JavaScript
├── routes/
│   ├── web.php             # Routes web
│   └── api.php             # Routes API
├── storage/                # Logs, cache, uploads (www-data)
├── .env                    # Konfigurasi environment
└── composer.json           # Dependensi PHP
```

---

## Troubleshooting

### Error: readonly database
```bash
sudo chown -R www-data:www-data /home/ubuntu/my-laravel-app/database
sudo chmod -R 775 /home/ubuntu/my-laravel-app/database
```

### Error: Port 80 sudah dipakai
```bash
sudo lsof -i :80          # Cek proses yang menggunakan port 80
sudo kill <PID>           # Hentikan proses tersebut
sudo systemctl start nginx
```

### Nginx gagal start
```bash
sudo nginx -t             # Cek error konfigurasi
sudo journalctl -xeu nginx.service --no-pager | tail -20
```

### Reload setelah perubahan konfigurasi
```bash
sudo nginx -t && sudo systemctl reload nginx
```
