# DOKUMEN LAPORAN TUGAS S4-01
## FINAL BUG FIXING (RELEASE CANDIDATE) & CLOSED ISSUE TRACKER LOG

---

### INFORMASI DOKUMEN & IDENTITAS PROYEK

| Parameter | Keterangan |
| :--- | :--- |
| **Nama Aplikasi** | **ENGLIFY** (*English Learning Gamified Platform*) |
| **Institusi** | SMK Budi Bakti Ciwidey |
| **Program Keahlian** | Rekayasa Perangkat Lunak (RPL) / Pengembangan Perangkat Lunak dan Gim (PPLG) |
| **Agenda Asesmen** | Uji Kompetensi Keahlian (UKK) Tahun 2026 |
| **Kode & Nama Tugas** | **S4-01 — Final Bug Fixing (Release Candidate)** |
| **Penanggung Jawab** | **Siswa 1:** Nur Aprilia (*Frontend Developer & UI/UX Designer*)<br>**Siswa 2:** Anggia Tresa Putri (*Backend & Database Developer*) |
| **Repositori GitHub** | `https://github.com/trespage/englify-lunarway.git` |
| **Branch & Commit RC** | `main` (Kode Final: `d5065f7` • Tag `v1.0.0-rc`: `b9d1e91`) |
| **Git Release Tag** | **`v1.0.0-rc`** |
| **URL Live Hosting** | `https://englify.my.id` |
| **Tanggal Penyusunan** | 11 November 2026 |

---

## BAB I — RINGKASAN EKSEKUTIF & FOKUS AKTIVITAS

Tugas **S4-01 (Final Bug Fixing — Release Candidate)** merupakan gerbang penjaminan mutu (*Quality Assurance Gate*) pada tahap awal **Sprint 4**. Fokus utama aktivitas ini adalah:

1. **Menuntaskan Seluruh Tiket Cacat Sisa:** Mengidentifikasi dan menutup seluruh bug fungsional, kompatibilitas server produksi (*strict MySQL*, *case-sensitive Linux*, *Vite build assets*), keamanan endpoint REST API, serta standar autoloading PSR-4.
2. **Validasi Audit Kesiapan Produksi:** Memastikan sintaks PHP bebas galat, seluruh rute aplikasi dan template Blade dapat di-*cache* tanpa error, serta mengoptimasi *autoloader* produksi tanpa peringatan.
3. **Code Freeze & Git Release Tag:** Mengunci penambahan fitur baru pada kode inti aplikasi, memverifikasi kondisi repositori bersih (*clean working tree*), dan menerbitkan penanda rilis resmi **`v1.0.0-rc`** di repositori GitHub.
4. **Penyusunan Evidence Wajib:** Menyusun **Closed Issue Tracker Log** sebagai bukti dokumentasi penyelesaian masalah secara sistematis dan teraudit.

---

## BAB II — MATRIKS JOB SHEET S4-01

| Kode Tugas | Nama Tugas Job Sheet | Fokus Kunci & Aktivitas | Penanggung Jawab | Output / Evidence Wajib | Status |
| :---: | :--- | :--- | :--- | :--- | :---: |
| **S4-01** | **Final Bug Fixing (Release Candidate)** | Menuntaskan seluruh tiket cacat sisa pasca-pengujian, mengunci perubahan kode (*code freeze*), memverifikasi *route/view cache* & *autoloader*, serta membuat Git Release Tag. | **Siswa 1** (Nur Aprilia) & **Siswa 2** (Anggia Tresa Putri) | 1. **Git Tag `v1.0.0-rc`**<br>2. **Closed Issue Tracker Log** | ✅ **Selesai (100%)** |

---

## BAB III — CLOSED ISSUE TRACKER LOG (*EVIDENCE WAJIB 1*)

Berikut adalah log lengkap seluruh tiket cacat (*bug*) dan celah teknis yang ditemukan selama proses *deployment* ke server produksi serta pengujian pengguna (*user testing*) bersama siswa, beserta akar masalah dan penyelesaiannya:

### Tabel 3.1 — Ringkasan Closed Issue Tracker Log

| ID Tiket | Kategori | Deskripsi Masalah (*Issue*) | Akar Masalah (*Root Cause*) | Tindakan Perbaikan (*Resolution*) | Commit Ref | PIC | Status |
| :---: | :--- | :--- | :--- | :--- | :---: | :---: | :---: |
| **BUG-01** | Backend / SQL | Grafik pertumbuhan akun di Dashboard Super Admin gagal dimuat pada server MySQL/MariaDB mode *strict*. | Penggunaan alias kolom `'d'` pada klausa `->groupBy('d')` ditolak oleh aturan `ONLY_FULL_GROUP_BY` pada server database hosting. | Mengubah ekspresi pengelompokan menjadi `->groupBy(DB::raw('DATE(created_at)'))` pada metode `dashboardStats()` di `app/Http/Controllers/superadmin/SuperAdminController.php`. | `9c15126` | Siswa 2 | ✅ **Closed** |
| **BUG-02** | Backend / SOP | Halaman error kustom menutupi detail *stack trace* ketika mode debug diaktifkan untuk kebutuhan diagnosa developer. | Exception renderer `QueryException` dan `HttpException (500)` di `bootstrap/app.php` langsung merender view error kustom tanpa memeriksa status `APP_DEBUG`. | Menambahkan kondisi `if (config('app.debug')) return null;` pada renderer `QueryException` dan `HttpException (500)` di `bootstrap/app.php`. | `9c15126` | Siswa 2 | ✅ **Closed** |
| **BUG-03** | Frontend / UI | Terjadi potensi galat *undefined variable* `$errors` pada tampilan dashboard Super Admin dalam kondisi *render* tertentu. | Pemanggilan langsung `$errors->any()` tanpa penjagaan keberadaan variabel pada `resources/views/superadmin/dashboard.blade.php`. | Menambahkan penjagaan *null-safe*: `@if(isset($errors) && $errors->any())`. | `9c15126` | Siswa 1 | ✅ **Closed** |
| **BUG-04** | DevOps / Build | Aset CSS Tailwind v4 dan JS Vite gagal termuat di server *shared hosting* yang tidak memiliki runtime Node.js/NPM. | Direktori hasil kompilasi `public/build` sebelumnya masuk dalam daftar `.gitignore` sehingga tidak ikut terunggah ke server produksi. | Menghapus entri `public/build` dari `.gitignore` dan mengompilasi aset produksi (`npm run build`) agar siap pakai di hosting. | `bff1dc5`, `cc7e693` | Siswa 1 & 2 | ✅ **Closed** |
| **BUG-05** | Backend / Linux | *Class controller* gagal ditemukan saat aplikasi dijalankan di sistem operasi server hosting Linux (*case-sensitive*). | Pernyataan `use` di `routes/web.php` memakai awalan huruf kapital (`Admin\...`, `Siswa\...`, `Superadmin\...`), sedangkan nama folder fisik pada server berhuruf kecil (`admin/`, `siswa/`, `superadmin/`). | Menyeragamkan seluruh pernyataan `use` controller di `routes/web.php` agar cocok dengan penamaan direktori huruf kecil. | `298b619` | Siswa 2 | ✅ **Closed** |
| **BUG-06** | Security / API | Endpoint `/api/users` dan `/api/monitoring` di `routes/api.php` terbuka untuk akses publik tanpa autentikasi (*Information Disclosure*). | Kedua grup rute API tersebut belum dibungkus middleware sesi autentikasi dan kontrol akses peran (RBAC). | Membungkus `/api/monitoring*` dengan `middleware(['web', 'auth', 'role:admin,superadmin'])` dan `/api/users*` dengan `middleware(['web', 'auth', 'role:superadmin'])` di `routes/api.php`. | `6041d65` | Siswa 2 | ✅ **Closed** |
| **BUG-07** | Backend / API | Jumlah `materi_dibaca` dan `total_materi` pada endpoint `GET /api/siswa/progress` tidak sinkron dengan dashboard monitoring admin. | Metode `apiProgress()` menghitung semua baris `ProgressMateri` (termasuk status `'Started'`) dan total `Materi::count()` mentah (termasuk materi non-publik). | Memfilter status `where('status', 'Completed')` dan memakai scope `Materi::visibleForSiswa()->count()` pada `apiProgress()` di `app/Http/Controllers/siswa/SiswaController.php`. | `6041d65` | Siswa 2 | ✅ **Closed** |
| **BUG-08** | Backend / PSR-4 | Composer melewatkan 3 controller inti dari *optimized classmap* saat menjalankan `composer dump-autoload --optimize`. | Deklarasi `namespace` pada `AdminController.php`, `MateriController.php`, dan `SiswaController.php` masih menggunakan huruf kapital (`Admin`/`Siswa`), tidak sesuai nama folder fisik (`admin`/`siswa`). | Menyeragamkan `namespace` menjadi `App\Http\Controllers\admin;` dan `App\Http\Controllers\siswa;` pada ketiga berkas controller tersebut. | `3bffee9` | Siswa 2 | ✅ **Closed** |
| **BUG-09** | QA / Automated Test | 2 skenario di `Tests\Feature\ApiTest` gagal (`401`) karena masih menguji `/api/monitoring` dan `/api/users` sebagai akses publik tanpa login. | Skrip pengujian lama di `tests/Feature/ApiTest.php` belum disesuaikan dengan kebijakan keamanan RBAC baru dari `BUG-06`. | Memperbarui `tests/Feature/ApiTest.php` untuk memvalidasi `401` bagi tamu, `403` bagi siswa, dan `200` bagi Admin/Super Admin pada endpoint terlindungi. | `d5065f7` | Siswa 2 | ✅ **Closed** |

---

### Penjelasan Teknis Penyelesaian Per Kelompok Masalah

1. **Kompatibilitas Server Produksi & Hosting (`BUG-01`, `BUG-04`, `BUG-05`, `BUG-08`):**
   * Server produksi berbasis Linux dan MySQL/MariaDB mode *strict* memiliki aturan penamaan berkas *case-sensitive* dan validasi SQL ketat. Penyelarasan klausa `GROUP BY`, kompilasi aset `public/build`, serta penyeragaman nama direktori dan `namespace` PSR-4 memastikan aplikasi dapat berjalan optimal dengan `composer dump-autoload --optimize` tanpa satu pun *class* yang terlewat.
2. **Keamanan & Keandalan REST API (`BUG-06`, `BUG-07`):**
   * Endpoint sensitif yang memuat data akun dan rekap nilai siswa kini terisolasi dengan kode status standar (`401 Unauthorized` untuk tamu, `403 Forbidden` untuk peran tidak berwenang, dan `200 OK` untuk admin/pemilik yang sah). Kunci jawaban kuis tetap terlindungi oleh mekanisme `makeHidden(['kunci_jawaban'])` bagi non-admin.
3. **Kepatuhan Penanganan Error & UI Guard (`BUG-02`, `BUG-03`):**
   * Menjaga keseimbangan antara kebutuhan transparansi debug developer saat pengembangan (`APP_DEBUG=true`) dan keamanan pesan error kustom di produksi (`APP_DEBUG=false`, merujuk tampilan `errors.database`, `403`, `404`, `500`), serta memastikan tampilan dashboard aman dari galat variabel kosong.

---

## BAB IV — HASIL VERIFIKASI TEKNIS & AUDIT PRA-RELEASE

Setelah seluruh perbaikan selesai (`BUG-01` s.d. `BUG-09`), dilakukan rangkaian verifikasi otomatis menyeluruh tanpa menyentuh data produksi:

| No | Jenis Pemeriksaan | Perintah / Metode Uji | Hasil Observasi | Status |
| :-: | :--- | :--- | :--- | :---: |
| **1** | **Optimasi Autoloader PSR-4** | `composer dump-autoload --optimize` | `Generated optimized autoload files containing 6581 classes` dengan **0 peringatan PSR-4** (naik dari 6578 class yang sebelumnya melewati 3 controller). | ✅ **Lulus** |
| **2** | **Pemeriksaan Sintaks PHP** | `php -l` pada berkas controller yang diubah | `No syntax errors detected` pada `AdminController.php`, `MateriController.php`, dan `SiswaController.php`. | ✅ **Lulus** |
| **3** | **Validasi Kompilasi Rute** | `php artisan route:cache` & `route:clear` | `Routes cached successfully.` Seluruh **92 rute** web & API valid tanpa konflik nama atau metode hilang. | ✅ **Lulus** |
| **4** | **Validasi Kompilasi Template Blade** | `php artisan view:cache` & `view:clear` | `Blade templates cached successfully.` Seluruh berkas `.blade.php` terkompilasi tanpa galat sintaks. | ✅ **Lulus** |
| **5** | **Audit Respon Keamanan API** | Simulasi HTTP Kernel (`GET /api/*`) | Tamu pada `/api/users`, `/api/monitoring`, `/api/siswa/progress` memperoleh `401`; Siswa pada `/api/users` & `/api/monitoring` memperoleh `403`; Super Admin memperoleh `200`. | ✅ **Lulus** |
| **6** | **Full Automated Test Suite (PHPUnit)** | `php artisan test` *(MySQL 3306 aktif)* | **`Tests: 126 passed (796 assertions)`** dalam `34.68s` (**0 failed**, seluruh test unit & fitur lulus 100%). | ✅ **Lulus 100%** |

---

## BAB V — BUKTI *CODE FREEZE* & GIT RELEASE TAG `v1.0.0-rc` (*EVIDENCE WAJIB 2*)

### 5.1 Identitas Release Candidate di GitHub

* **Repositori Remote:** `https://github.com/trespage/englify-lunarway.git`
* **Branch Utama:** `main` (tersinkronisasi dengan `origin/main` dan server produksi `englify.my.id`)
* **Status Working Tree:** `nothing to commit, working tree clean` (saat penandaan tag final `v1.0.0-rc`)
* **Release Tag Resmi:** **`v1.0.0-rc`** (Annotated Tag pada commit `b9d1e91`, di atas kode & test final `d5065f7`)

### 5.2 Log Riwayat Commit Menuju `v1.0.0-rc`

```text
b9d1e91 (tag: v1.0.0-rc) docs(s4-01): update Closed Issue Tracker Log with 126 passing tests
d5065f7 test(api): align ApiTest assertions with RBAC API security
3bffee9 fix(psr4): align controller namespaces and finalize README for v1.0.0-rc
c40d41f Update README.md
6041d65 Update prd
1288d36 docs: update final PRD v5.0 production release and UKK assessment certified
298b619 bug
cc7e693 build: compile production assets to public/build for hosting deployment
bff1dc5 chore: remove public/build from gitignore
```

### 5.3 Kebijakan *Code Freeze* & Prosedur Sinkronisasi Aman ke Server Hosting

Sejak diterbitkannya tag **`v1.0.0-rc`**, repositori memasuki status **Code Freeze**:
1. Tidak ada lagi penambahan fitur baru di luar cakupan Sprint 1–3.
2. Seluruh data uji coba pengguna yang sudah tersimpan di hosting (*37 akun siswa, 32 rekap hasil kuis, 2.330 poin, serta progres belajar*) dijaga tetap utuh dengan hanya melakukan penarikan kode (*pull*) dan pembaruan cache tanpa menjalankan `migrate:fresh` atau `db:seed`:
   ```bash
   git pull origin main
   composer dump-autoload --optimize
   php artisan route:clear && php artisan config:clear && php artisan view:clear
   php artisan config:cache && php artisan route:cache
   ```

---

## BAB VI — LEMBAR PENGESAHAN

Dokumen laporan penyelesaian tugas **S4-01: Final Bug Fixing (Release Candidate)** ini disusun sesuai kondisi nyata repositori dan hasil verifikasi teknis aplikasi **ENGLIFY**.

<br />

| Disusun Oleh (Siswa 1 — Frontend) | Disusun Oleh (Siswa 2 — Backend) | Diperiksa / Disahkan Oleh (Penguji UKK) |
| :---: | :---: | :---: |
| <br /><br /><br /> | <br /><br /><br /> | <br /><br /><br /> |
| **Nur Aprilia** | **Anggia Tresa Putri** | *(................................................)* |
| *Frontend & UI/UX Developer* | *Backend & Database Developer* | *Asesor / Guru Pembimbing RPL* |

