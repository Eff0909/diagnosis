# SIDx — Sistem Diagnosis Penyakit (Naive Bayes)

Aplikasi web klasifikasi penyakit berdasarkan gejala menggunakan algoritma
**Naive Bayes (Bernoulli)**. Backend Laravel (REST API) + Frontend React (Vite).

Penyakit yang diklasifikasi: **Flu**, **DBD**, **Tipes**, **Maag**.

## Struktur Project

```
sidx-diagnosis/
├── backend/    -> file Laravel (Controller, Service, routes) — tinggal ditempel ke project Laravel baru
└── frontend/   -> project React (Vite) siap jalan
```

## 1. Setup Backend (Laravel)

file di sini hanya berisi logic inti (Controller, Service, routes),
perlu bikin project Laravel kosong dulu lalu tempel file-nya:

```bash
composer create-project laravel/laravel backend-laravel
cd backend-laravel
```

Lalu **timpa/copy** file berikut dari folder `backend/` project ini ke lokasi yang sama
di `backend-laravel/`:

- `app/Http/Controllers/DiagnosisController.php`
- `app/Services/NaiveBayesService.php` (folder `Services` belum ada, buat dulu)
- `routes/api.php` (tambahkan isi routes-nya ke file `routes/api.php` yang sudah ada)

Aktifkan CORS supaya React bisa akses API (Laravel 11 sudah punya `bootstrap/app.php`,
tambahkan middleware CORS bawaan atau install `fruitcake/laravel-cors` jika perlu).

Jalankan server:

```bash
php artisan serve
# jalan di http://localhost:8000
```

Test cepat:
```bash
curl http://localhost:8000/api/symptoms
```

## 2. Setup Frontend (React)

```bash
cd frontend
npm install
npm run dev
# jalan di http://localhost:5173
```

Pastikan backend Laravel jalan di `http://localhost:8000` (sudah di-hardcode di
`frontend/src/App.jsx` pada variabel `API_BASE`). Ubah kalau port/domain beda.

## 3. Cara Kerja Naive Bayes di Project Ini

1. Dataset training (10 sampel gejala per penyakit) ada di `NaiveBayesService::dataset()`.
2. Model menghitung **prior probability** tiap penyakit dan **conditional probability**
   tiap gejala per penyakit, pakai **Laplace smoothing** biar tidak ada probabilitas 0.
3. Saat user pilih gejala di form, backend menghitung skor tiap penyakit pakai
   rumus Bernoulli Naive Bayes (pakai log-probability biar tidak underflow),
   lalu dinormalisasi jadi persentase pakai softmax.
4. Hasil diurutkan dari probabilitas tertinggi dan dikirim ke frontend.

## 4. Push ke GitHub

```bash
git init
git add .
git commit -m "SIDx: Sistem Diagnosis Penyakit - Naive Bayes (Laravel + React)"
git branch -M main
git remote add origin https://github.com/<username-kamu>/sidx-diagnosis.git
git push -u origin main
```

