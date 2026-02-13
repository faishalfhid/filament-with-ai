# 🚀 CI/CD Laravel via GitHub Actions (Deploy ke Hostinger via SSH)

## 📌 Arsitektur

```
Push ke GitHub
      ↓
GitHub Actions berjalan
      ↓
SSH ke Server Hostinger
      ↓
git pull + composer install + migrate + cache clear
```

---

# ⚙️ Step-by-Step Setup

---

## 1️⃣ Persiapan Server (Hostinger)

Pastikan di server sudah terinstall:

* ✅ Git
* ✅ Composer
* ✅ PHP
* ✅ Akses SSH aktif

Cek via SSH:

```bash
git --version
composer --version
php -v
```

---

## 2️⃣ Buat File GitHub Actions

Di repository Laravel, buat folder:

```
.github/workflows/
```

Lalu buat file:

```
deploy.yml
```

---

## 3️⃣ Isi File `deploy.yml`

```yaml
name: Deploy Laravel to Hostinger

on:
  push:
    branches:
      - main

jobs:
  deploy:
    runs-on: ubuntu-latest

    steps:
      - name: Deploy via SSH
        uses: appleboy/ssh-action@v0.1.10
        with:
          host: ${{ secrets.HOST }}
          username: ${{ secrets.USERNAME }}
          password: ${{ secrets.PASSWORD }}
          port: 22
          script: |
            cd domains/public_html
            git pull origin main
            composer install --no-dev --optimize-autoloader
            php artisan config:clear
            php artisan config:cache
            php artisan route:cache
            php artisan view:cache
```

---

## 4️⃣ Tambahkan GitHub Secrets

Masuk ke:

```
Repository → Settings → Secrets and variables → Actions
```

Tambahkan:

| Secret Name | Isi                 |
| ----------- | ------------------- |
| `HOST`      | IP server Hostinger |
| `USERNAME`  | Username SSH        |
| `PASSWORD`  | Password SSH        |

---

# 🔐 Skenario Jika Repository Private

Jika repository **private**, server tidak bisa langsung `git pull`.
Solusinya gunakan **Deploy Key (SSH Key)**.

---

## Langkah-langkah:

### 1️⃣ Generate SSH Key di Hostinger

Masuk ke:

```
Hostinger → Advanced → Git
```

Generate SSH Key.

---

### 2️⃣ Tambahkan Deploy Key ke GitHub

Masuk ke:

```
Repository → Settings → Deploy Keys → Add Deploy Key
```

* Paste public key dari Hostinger
* Centang **Allow write access** (jika perlu)

---

### 3️⃣ Test dari Server

Login SSH ke server lalu jalankan:

```bash
git pull origin main
```

Jika berhasil tanpa password, berarti sudah benar ✅

---

# 🧠 Best Practice (Disarankan)

Lebih aman menggunakan **SSH Key daripada password** di GitHub Actions.

Contoh jika pakai SSH private key:

Tambahkan secret:

```
SSH_KEY
```

Lalu ubah workflow menjadi:

```yaml
with:
  host: ${{ secrets.HOST }}
  username: ${{ secrets.USERNAME }}
  key: ${{ secrets.SSH_KEY }}
```

---

# 🎯 Hasil Akhir

Sekarang setiap:

```
git push origin main
```

Akan otomatis:

* Connect ke server
* Pull update terbaru
* Install dependency
* Clear & cache ulang config Laravel
* Deploy selesai 🚀
