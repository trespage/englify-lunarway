<div align="center">

<br />

# Panduan Penggunaan Aplikasi Sistem Pembelajaran Bahasa Inggris Interaktif Berbasis Web

# **ENGLIFY**

### Versi 1.0 | Tahun 2026

<br />

*[Sisipkan Logo SMK Budi Bakti Ciwidey]*

<br />

**Tim Pengembang:**

### **TIM LUNARWAY**

ANGGIA TRESA PUTRI  
NUR APRILIA

<br />

**SMK BUDI BAKTI CIWIDEY**  
Jl. Babakan Tiga No.82, Ciwidey, Kec. Ciwidey,  
Kabupaten Bandung, Jawa Barat 40973

</div>

---

<div align="center">

## KATA PENGANTAR

</div>

Puji dan syukur kami panjatkan ke hadirat Allah SWT atas selesainya penyusunan **Manual Book Aplikasi ENGLIFY (*English Learning Gamified Platform*)** ini. Manual book ini disusun sebagai panduan resmi penggunaan aplikasi ENGLIFY yang dikembangkan oleh **Tim LunarWay** dalam rangka memenuhi persyaratan **Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak Tahun 2026** di **SMK Budi Bakti Ciwidey**.

Aplikasi ENGLIFY hadir sebagai solusi digital untuk mempermudah pembelajaran Bahasa Inggris secara terstruktur, terukur, dan interaktif, menggantikan proses penyampaian materi serta evaluasi konvensional yang kurang fleksibel dan sulit dipantau progresnya secara langsung. Dengan fitur alur belajar berurutan (*Sequential Learning Flow*), *Focus Mode Anti-Exit Lock*, soal kuis interaktif lengkap dengan pemutar audio *listening*, *Word-Style Dual-Mode Editor*, serta sistem poin dan pemantauan otomatis, ENGLIFY dirancang agar mudah digunakan oleh seluruh pengguna.

Manual book ini menjelaskan secara lengkap cara instalasi, konfigurasi, dan penggunaan aplikasi untuk setiap peran pengguna (**Super Admin**, **Admin Divisi**, dan **Siswa**), beserta solusi pemecahan masalah umum (*troubleshooting*). Kami berharap panduan ini dapat mempermudah pengguna dalam memahami dan memanfaatkan seluruh fitur yang tersedia.

Ciwidey, November 2026  
Tim Penyusun,

**Anggia Tresa Putri & Nur Aprilia**

---

<div align="center">

## DAFTAR ISI

</div>

* **BAB I - PENDAHULUAN**
  * 1.1 Deskripsi Sistem
  * 1.2 Kebutuhan Sistem (*System Requirements*)
  * 1.3 Hak Akses Pengguna (*Role User*)
* **BAB II - PANDUAN INSTALASI & KONFIGURASI**
  * 2.1 Prasyarat Instalasi
  * 2.2 Langkah Instalasi Aplikasi
  * 2.3 Konfigurasi & Migrasi Database
  * 2.4 Generate Application Key & Jalankan Aplikasi
  * 2.5 Akun Default Aplikasi
* **BAB III - PANDUAN PENGGUNAAN (*USER GUIDE*)**
  * 3.1 Cara Login ke Aplikasi
  * 3.2 Panduan untuk Super Admin
  * 3.3 Panduan untuk Admin Divisi
  * 3.4 Panduan untuk Siswa
* **BAB IV - TROUBLESHOOTING (*PEMECAHAN MASALAH*)**
  * 4.1 Daftar Masalah dan Solusi
  * 4.2 Tips Pemeliharaan Sistem

---

<div align="center">

## DAFTAR GAMBAR

</div>

| No. Gambar | Judul Gambar | Bagian |
| :--- | :--- | :--- |
| **Gambar 2.1** | Struktur Folder Proyek ENGLIFY | Bab II (2.2.1) |
| **Gambar 2.2** | Konfigurasi Database pada File `.env` | Bab II (2.2.3) |
| **Gambar 2.3** | Tampilan Database `englify_db` di phpMyAdmin | Bab II (2.3) |
| **Gambar 3.1** | Halaman Depan (*Landing Page*) ENGLIFY | Bab III (3.1) |
| **Gambar 3.2** | Halaman Login ENGLIFY | Bab III (3.1) |
| **Gambar 3.3** | Halaman Wajib Ganti Password (Login Pertama Siswa) | Bab III (3.1) |
| **Gambar 3.4** | Dashboard Super Admin | Bab III (3.2.1) |
| **Gambar 3.5** | Menu Sidebar Navigasi Super Admin | Bab III (3.2.2) |
| **Gambar 3.6** | Halaman Kelola Akun Siswa (Super Admin) | Bab III (3.2.3) |
| **Gambar 3.7** | Form Tambah / Edit Akun Siswa | Bab III (3.2.3) |
| **Gambar 3.8** | Halaman Kelola Akun Admin Divisi | Bab III (3.2.4) |
| **Gambar 3.9** | Halaman Data Sistem & Status Basis Data | Bab III (3.2.5) |
| **Gambar 3.10** | Halaman Profil & Avatar Super Admin | Bab III (3.2.6) |
| **Gambar 3.11** | Dashboard Admin Divisi | Bab III (3.3.1) |
| **Gambar 3.12** | Halaman Kelola Kategori | Bab III (3.3.2) |
| **Gambar 3.13** | Form Tambah Kategori | Bab III (3.3.2) |
| **Gambar 3.14** | Halaman Kelola Bab | Bab III (3.3.3) |
| **Gambar 3.15** | Form Tambah Bab | Bab III (3.3.3) |
| **Gambar 3.16** | Halaman Kelola Materi | Bab III (3.3.4) |
| **Gambar 3.17** | *Word-Style Dual-Mode Editor* (Tambah / Edit Materi) | Bab III (3.3.4) |
| **Gambar 3.18** | Halaman Kelola Quiz | Bab III (3.3.5) |
| **Gambar 3.19** | Form Tambah Soal Quiz & Unggah Audio Listening | Bab III (3.3.5) |
| **Gambar 3.20** | Halaman Hasil Quiz (Evaluasi & Rekap Tersimpan) | Bab III (3.3.6) |
| **Gambar 3.21** | Halaman Detail Jawaban Siswa per Soal | Bab III (3.3.6) |
| **Gambar 3.22** | Halaman Monitoring Per Siswa | Bab III (3.3.7) |
| **Gambar 3.23** | Halaman Detail Monitoring Individu Siswa | Bab III (3.3.7) |
| **Gambar 3.24** | Halaman Kirim Reminder ke Siswa | Bab III (3.3.8) |
| **Gambar 3.25** | Dashboard Siswa | Bab III (3.4.1) |
| **Gambar 3.26** | Halaman Daftar Materi & Status Gembok Sekuensial | Bab III (3.4.2) |
| **Gambar 3.27** | Halaman Baca Materi (*Focus Mode Aktif*) | Bab III (3.4.3) |
| **Gambar 3.28** | Halaman Pengerjaan Quiz & Pemutar Audio Listening | Bab III (3.4.4) |
| **Gambar 3.29** | Halaman Hasil Quiz & Pembahasan (Tampil 1x) | Bab III (3.4.5) |
| **Gambar 3.30** | Halaman Peta Quiz (*Rute Skor*) | Bab III (3.4.6) |
| **Gambar 3.31** | Halaman Progress Belajar & Lencana Pencapaian | Bab III (3.4.6) |
| **Gambar 3.32** | Halaman Reminder & Notifikasi Siswa | Bab III (3.4.7) |
| **Gambar 3.33** | Halaman Profil & Pemilihan 6 Avatar Maskot Kucing | Bab III (3.4.7) |

---

<div align="center">

## DAFTAR TABEL

</div>

| No. Tabel | Judul Tabel | Bagian |
| :--- | :--- | :--- |
| **Tabel 1.1** | Spesifikasi Minimum Hardware | Bab I (1.2) |
| **Tabel 1.2** | Spesifikasi Software yang Dibutuhkan | Bab I (1.2) |
| **Tabel 1.3** | Daftar Hak Akses Berdasarkan Peran | Bab I (1.3) |
| **Tabel 2.1** | Akun Default Aplikasi (*Seeder*) | Bab II (2.5) |
| **Tabel 3.1** | Rumus Penilaian Skor, Poin, Rata-rata & Progress | Bab III (3.4.5) |
| **Tabel 4.1** | Daftar Masalah dan Solusi (*Troubleshooting*) | Bab IV (4.1) |

---

# BAB I  
# PENDAHULUAN

### 1.1 Deskripsi Sistem
Aplikasi **ENGLIFY (*English Learning Gamified Platform*)** adalah sistem pembelajaran Bahasa Inggris berbasis web yang dirancang khusus untuk menunjang kompetensi siswa Sekolah Menengah Kejuruan (SMK). Sistem ini menghadirkan media belajar yang terstruktur per divisi keahlian (**Speaking**, **Writing**, **Listening**, dan **Reading**) serta evaluasi berbasis kuis interaktif secara *real-time*.

**Permasalahan yang dipecahkan oleh ENGLIFY:**
* Belum tersedianya media pembelajaran daring yang memadukan materi bacaan dengan audio *listening* secara terpadu.
* Siswa sering melompati materi dasar dan langsung mencoba kuis tanpa membaca materinya terlebih dahulu.
* Rendahnya integritas ujian daring akibat siswa bebas membuka halaman lain atau membocorkan kunci jawaban riwayat kuis.
* Kesulitan pengajar dalam memantau progres membaca dan evaluasi nilai seluruh siswa secara *real-time*.

**Fitur Utama Aplikasi ENGLIFY:**
* Manajemen kurikulum berjenjang: **Kategori Divisi $\rightarrow$ Bab $\rightarrow$ Materi $\rightarrow$ Quiz**.
* Penyusunan modul ajar menggunakan ***Word-Style Dual-Mode Editor*** (Mode Standar & Layar Penuh) dengan unggah foto langsung ke paragraf.
* Alur belajar berurutan (**Sequential Lock**): materi selanjutnya otomatis terbuka setelah materi & kuis sebelumnya diselesaikan.
* **Focus Mode Anti-Exit Lock**: mengunci navigasi siswa saat membaca materi berkuesioner maupun saat mengerjakan kuis.
* Kuis interaktif dengan *countdown timer*, pengacakan opsi pilihan ganda, pemutar audio *listening*, dan proteksi kunci jawaban (hanya tampil 1 kali tepat setelah *submit*).
* Gamifikasi poin akumulatif, peta kuis (*Rute Skor*), lencana pencapaian, pesan *reminder* guru, serta **6 pilihan avatar maskot kucing Englify**.
* Pemisahan hak akses berbasis peran (**RBAC**) antara **Super Admin**, **Admin Divisi**, dan **Siswa**.

---

### 1.2 Kebutuhan Sistem (*System Requirements*)

#### Tabel 1.1 - Spesifikasi Minimum Hardware
| Komponen | Spesifikasi Minimum |
| :--- | :--- |
| **Processor** | Intel Core i3 / AMD Ryzen 3 atau setara |
| **RAM** | 4 GB (disarankan 8 GB) |
| **Storage** | 20 GB ruang kosong |
| **Layar** | 1280 x 720 px (disarankan Full HD 1920x1080) |
| **Jaringan** | Koneksi Internet / WiFi (untuk akses live `https://englify.my.id`) |

#### Tabel 1.2 - Spesifikasi Software yang Dibutuhkan
| Software | Versi / Keterangan |
| :--- | :--- |
| **XAMPP / Laragon** | v8.2.4 atau lebih baru (untuk instalasi lokal) |
| **PHP** | v8.2 atau lebih baru (ekstensi `pdo_mysql`, `mbstring`, `openssl`, `gd`, `fileinfo`) |
| **MySQL / MariaDB** | MySQL 8.x / MariaDB 10.4+ (Engine InnoDB) |
| **Composer** | v2.x (untuk instalasi dependensi Laravel 12) |
| **Node.js & NPM** | v18.x atau lebih baru (untuk kompilasi aset Tailwind CSS v4 & Vite) |
| **Web Browser** | Google Chrome / Mozilla Firefox / Microsoft Edge versi terbaru |
| **Text Editor** | Visual Studio Code (opsional, untuk konfigurasi kode) |
| **OS** | Windows 10/11, Linux Ubuntu 20.04+, atau macOS |

---

### 1.3 Hak Akses Pengguna (*Role User*)
Aplikasi ENGLIFY memiliki **tiga peran pengguna** dengan pembatasan hak akses yang ketat. Tabel berikut merinci fitur yang dapat diakses oleh masing-masing peran.

#### Tabel 1.3 - Daftar Hak Akses Berdasarkan Peran
| Fitur / Menu | Super Admin | Admin Divisi | Siswa |
| :--- | :---: | :---: | :---: |
| **Login & Logout** | ✓ | ✓ | ✓ |
| **Wajib Ganti Password Login Pertama** | ✗ | ✗ | ✓ *(Saat flag aktif)* |
| **Dashboard** | ✓ *(Statistik Global)* | ✓ *(Statistik Pengajar)* | ✓ *(Ringkasan Belajar)* |
| **Kelola Akun Siswa & Admin Divisi** | ✓ *(CRUD & Aktif/Nonaktif)* | ✗ | ✗ |
| **Data Sistem & Kesehatan Database** | ✓ | ✗ | ✗ |
| **Kelola Kategori Divisi** | ✗ | ✓ *(CRUD)* | ✗ |
| **Kelola Bab Pembelajaran** | ✗ | ✓ *(CRUD & Toggle Aktif)* | ✗ |
| **Kelola Materi (*Word-Style Editor*)** | ✗ | ✓ *(CRUD & Upload Gambar)* | ✗ |
| **Kelola Bank Quiz & Audio Listening** | ✗ | ✓ *(CRUD & Upload Audio)* | ✗ |
| **Lihat Hasil Quiz & Detail Jawaban** | ✗ | ✓ *(Semua Siswa)* | ✓ *(Skor Pribadi)* |
| **Monitoring Per Siswa** | ✗ | ✓ *(Semua Siswa)* | ✗ |
| **Kirim Reminder ke Siswa** | ✗ | ✓ | ✗ |
| **Baca Materi & Focus Mode** | ✗ | ✗ | ✓ |
| **Kerjakan Quiz & Peta Quiz** | ✗ | ✗ | ✓ |
| **Progress Belajar & Reminder Masuk** | ✗ | ✗ | ✓ |
| **Edit Profil & Pilih Avatar Kucing** | ✓ | ✓ | ✓ |

---

# BAB II  
# PANDUAN INSTALASI & KONFIGURASI

> **Catatan Akses Live Hosting:**  
> Bagi pengguna umum (Siswa, Guru, atau Penguji) yang mengakses aplikasi secara daring di **`https://englify.my.id`**, Anda **tidak perlu melakukan instalasi lokal** pada Bab II ini dan dapat langsung melompat ke **Bab III (Panduan Penggunaan)**. Bab II ditujukan bagi pengembang atau teknisi yang memasang aplikasi di komputer lokal (*localhost*).

### 2.1 Prasyarat Instalasi
Sebelum memulai instalasi lokal, pastikan perangkat lunak berikut telah terpasang pada komputer Anda:
1. **XAMPP** versi 8.2.4 atau lebih baru (*atau Laragon dengan PHP 8.2+*) — unduh di: `https://www.apachefriends.org`
2. **Composer** versi 2.x — unduh di: `https://getcomposer.org`
3. **Node.js** versi 18.x atau lebih baru — unduh di: `https://nodejs.org`
4. **Git** (opsional jika mengambil kode via GitHub) — unduh di: `https://git-scm.com`
5. **Browser modern** (Google Chrome, Mozilla Firefox, atau Microsoft Edge versi terbaru)

---

### 2.2 Langkah Instalasi Aplikasi

#### 2.2.1 Clone atau Salin File Proyek
6. Clone repositori GitHub atau ekstrak file proyek ke direktori kerja Anda (misal: `D:\englify-app` atau `C:\xampp\htdocs\englify-app`):
   ```bash
   git clone https://github.com/trespage/englify-lunarway.git
   ```
7. Pastikan struktur folder proyek memiliki berkas `artisan`, `composer.json`, serta folder `app/`, `database/`, `resources/`, dan `routes/` di dalamnya.

> *[Sisipkan Screenshot: Explorer struktur folder proyek ENGLIFY]*  
> *Gambar 2.1 - Struktur Folder Proyek ENGLIFY*

#### 2.2.2 Instalasi Dependensi via Composer
8. Buka Command Prompt (CMD) atau Terminal.
9. Arahkan ke folder proyek dengan perintah: `cd path\ke\englify-app`
10. Jalankan perintah:
    ```bash
    composer install
    ```
11. Tunggu hingga proses selesai. Folder `vendor` akan terbuat secara otomatis.

#### 2.2.3 Konfigurasi File `.env`
12. Salin berkas `.env.example` menjadi `.env` pada folder utama (*root*) proyek:
    ```bash
    copy .env.example .env
    ```
13. Buka berkas `.env` menggunakan teks editor (VS Code / Notepad).
14. Sesuaikan konfigurasi aplikasi dan database sebagai berikut:
    ```ini
    APP_NAME=Englify
    APP_ENV=local
    APP_DEBUG=true
    APP_URL=http://127.0.0.1:8000
    APP_TIMEZONE=Asia/Jakarta

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=englify_db
    DB_USERNAME=root
    DB_PASSWORD=

    SESSION_DRIVER=file
    ```

> *[Sisipkan Screenshot: Isi konfigurasi database pada file .env]*  
> *Gambar 2.2 - Konfigurasi Database pada File `.env`*

15. Simpan berkas `.env`.

---

### 2.3 Konfigurasi & Migrasi Database
16. Aktifkan **XAMPP Control Panel** dan pastikan layanan **Apache** dan **MySQL** berjalan (*Running*).
17. Buka browser dan akses **phpMyAdmin** di: `http://localhost/phpmyadmin`
18. Buat database baru dengan nama **`englify_db`** (pilih kolasi **`utf8mb4_unicode_ci`**).
19. Kembali ke terminal di dalam folder proyek, lalu jalankan perintah migrasi tabel dan pengisian data awal (*seeder*) secara otomatis:
    ```bash
    php artisan migrate --seed
    ```
    *(Alternatif: Jika Anda menerima file backup `.sql`, gunakan tab **Import** di phpMyAdmin lalu pilih file `.sql` dan klik **Go/Kirim**).*

> *[Sisipkan Screenshot: Tampilan tabel database englify_db di phpMyAdmin]*  
> *Gambar 2.3 - Tampilan Database `englify_db` di phpMyAdmin*

---

### 2.4 Generate Application Key & Jalankan Aplikasi
20. Pada terminal di dalam folder proyek, jalankan perintah untuk membuat kunci enkripsi aplikasi:
    ```bash
    php artisan key:generate
    ```
21. Hubungkan folder penyimpanan publik agar gambar materi dan audio dapat diakses:
    ```bash
    php artisan storage:link
    ```
22. Install paket frontend dan kompilasi aset CSS/JS (atau gunakan hasil build yang sudah tersedia di `public/build/`):
    ```bash
    npm install && npm run build
    ```
23. Jalankan server lokal Laravel:
    ```bash
    php artisan serve
    ```
24. Buka browser dan akses aplikasi melalui: `http://127.0.0.1:8000`  
    *(Untuk akses versi online production, kunjungi: **`https://englify.my.id`**).*

---

### 2.5 Akun Default Aplikasi

Setelah menjalankan *seeder* awal (`DatabaseSeeder`), berikut daftar akun bawaan yang dapat digunakan untuk uji coba lokal:

#### Tabel 2.1 - Akun Default Aplikasi (*Seeder*)
| Peran (*Role*) | Email | Username | Password | Keterangan |
| :--- | :--- | :--- | :--- | :--- |
| **Super Admin** | `superadmin@englify.com` | `superadmin` | `password123` | Akses penuh kelola akun & sistem |
| **Admin Divisi** | `adminenglish@englify.com` | `adminenglish` | `password123` | Akses kelola kurikulum & monitoring |
| **Siswa** | `siswa@englify.com` | `siswa` | `password123` | Akses materi, kuis & progres belajar |

> **Peringatan Keamanan:** Demi keamanan, segera ganti seluruh kata sandi akun bawaan pada lingkungan server *production* (`https://englify.my.id`).

---

# BAB III  
# PANDUAN PENGGUNAAN (*USER GUIDE*)

### 3.1 Cara Login ke Aplikasi
Langkah-langkah masuk ke dalam aplikasi ENGLIFY:
25. Buka browser, lalu akses URL aplikasi ENGLIFY (misal: `https://englify.my.id` atau `http://127.0.0.1:8000`).

> *[Sisipkan Screenshot: Tampilan Halaman Depan / Landing Page ENGLIFY]*  
> *Gambar 3.1 - Halaman Depan (*Landing Page*) ENGLIFY*

26. Klik tombol **Masuk / Login** pada halaman utama untuk membuka formulir login.
27. Masukkan **Email** atau **Username** serta **Password** yang sesuai dengan akun Anda.
28. Klik tombol **Masuk**. Sistem otomatis mengarahkan Anda ke halaman Dashboard sesuai peran masing-masing.

> *[Sisipkan Screenshot: Halaman Login ENGLIFY]*  
> *Gambar 3.2 - Halaman Login ENGLIFY (masukkan email/username dan password lalu klik Masuk)*

29. **Khusus Login Pertama Siswa Baru:** Jika akun Anda baru saja dibuat oleh Super Admin, sistem otomatis mengarahkan Anda ke halaman **Ganti Password** (`/change-password`). Masukkan password lama dan buat password baru minimal 6 karakter sebelum melanjutkan ke Dashboard Siswa.

> *[Sisipkan Screenshot: Halaman Wajib Ganti Password pada login pertama siswa]*  
> *Gambar 3.3 - Halaman Wajib Ganti Password (Login Pertama Siswa)*

---

### 3.2 Panduan untuk Super Admin

#### 3.2.1 Dashboard Super Admin
Setelah login sebagai Super Admin, halaman Dashboard menampilkan statistik real-time (Total Siswa, Total Admin, Total Divisi, dan Akun Aktif) beserta grafik pertumbuhan akun dalam 7 hari terakhir.

> *[Sisipkan Screenshot: Dashboard Super Admin]*  
> *Gambar 3.4 - Dashboard Super Admin menampilkan ringkasan statistik & grafik pertumbuhan*

#### 3.2.2 Menu Sidebar Navigasi Super Admin
Pada panel kiri terdapat menu utama Super Admin: **Dashboard**, **Kelola Akun** (*Akun Siswa* & *Akun Admin Divisi*), **Data Sistem**, **Profil**, serta tombol **Logout** di bagian bawah.

> *[Sisipkan Screenshot: Menu Sidebar Navigasi Super Admin]*  
> *Gambar 3.5 - Menu Sidebar Navigasi Super Admin*

#### 3.2.3 Kelola Akun Siswa
* Klik menu **Kelola Akun $\rightarrow$ Akun Siswa** pada sidebar kiri.
* Klik **Tambah Siswa**, lalu isi Nama, Email, Status (`aktif`/`nonaktif`), dan Password *(jika dikosongkan, default password adalah `password123`)*. Sistem otomatis membuat username unik dan menandai akun wajib mengganti password saat login pertama.
* Gunakan tombol **Edit** untuk mengubah data, mereset kata sandi, atau mengubah status akun menjadi **`nonaktif`** *(akun nonaktif langsung diblokir dari akses login)*.
* Gunakan tombol **Hapus** untuk menghapus akun siswa beserta data progres terkait.

> *[Sisipkan Screenshot: Halaman Daftar Akun Siswa]*  
> *Gambar 3.6 - Halaman Kelola Akun Siswa*

> *[Sisipkan Screenshot: Form Tambah / Edit Akun Siswa]*  
> *Gambar 3.7 - Form Tambah / Edit Akun Siswa*

#### 3.2.4 Kelola Akun Admin Divisi
* Klik menu **Kelola Akun $\rightarrow$ Akun Admin Divisi**.
* Tambah, edit, atau hapus akun pengajar/admin divisi. Berbeda dengan siswa, Admin Divisi tidak dipaksa mengganti password saat login pertama.

> *[Sisipkan Screenshot: Halaman Kelola Akun Admin Divisi]*  
> *Gambar 3.8 - Halaman Kelola Akun Admin Divisi*

#### 3.2.5 Data Sistem & Status Basis Data
* Klik menu **Data Sistem** pada sidebar.
* Halaman ini menampilkan status konektivitas basis data secara real-time (**Online / Normal** atau **Offline / Gangguan**), versi PHP, versi Laravel, jenis database, serta kapasitas penyimpanan disk server.

> *[Sisipkan Screenshot: Halaman Data Sistem Super Admin]*  
> *Gambar 3.9 - Halaman Data Sistem & Status Basis Data*

#### 3.2.6 Profil & Avatar Super Admin
* Klik menu **Profil** untuk memperbarui nama, email, kata sandi, atau mengganti avatar karakter kucing Englify.

> *[Sisipkan Screenshot: Halaman Profil Super Admin]*  
> *Gambar 3.10 - Halaman Profil & Avatar Super Admin*

---

### 3.3 Panduan untuk Admin Divisi

#### 3.3.1 Dashboard Admin Divisi
Setelah login sebagai Admin Divisi, halaman Dashboard menampilkan ringkasan kurikulum (Total Materi, Total Quiz, Total Siswa, Total Divisi), rata-rata nilai kelas, aktivitas belajar bulan ini, dan tips harian pengajaran.

> *[Sisipkan Screenshot: Dashboard Admin Divisi]*  
> *Gambar 3.11 - Dashboard Admin Divisi*

#### 3.3.2 Kelola Kategori
Kategori digunakan untuk mengelompokkan materi sesuai divisi kompetensi Bahasa Inggris (*Speaking, Writing, Listening, Reading*).
* Klik menu **Kelola Kategori** pada sidebar kiri.
* Klik **Tambah Kategori**, isi Nama Kategori dan Deskripsi, lalu klik **Simpan**.
* Gunakan tombol aksi **Edit** atau **Hapus** pada kolom aksi tabel *(menghapus kategori turut menghapus bab, materi, dan kuis di dalamnya)*.

> *[Sisipkan Screenshot: Halaman Kelola Kategori]*  
> *Gambar 3.12 - Halaman Kelola Kategori*

> *[Sisipkan Screenshot: Form Tambah Kategori]*  
> *Gambar 3.13 - Form Tambah Kategori*

#### 3.3.3 Kelola Bab
* Klik menu **Kelola Bab** pada sidebar.
* Klik **Tambah Bab**, pilih **Kategori**, lalu isi **Judul Bab**, **Urutan** *(terisi otomatis secara berurutan oleh sistem)*, **Durasi Pengerjaan Kuis (menit)**, serta status **Aktif / Nonaktif**.
* Bab yang berstatus nonaktif akan disembunyikan sementara dari siswa.

> *[Sisipkan Screenshot: Halaman Kelola Bab]*  
> *Gambar 3.14 - Halaman Kelola Bab*

> *[Sisipkan Screenshot: Form Tambah Bab]*  
> *Gambar 3.15 - Form Tambah Bab*

#### 3.3.4 Kelola Materi (*Word-Style Dual-Mode Editor*)
* Klik menu **Kelola Materi** pada sidebar. Gunakan filter **Kategori** atau **Bab** untuk mempermudah pencarian.
* Klik **Tambah Materi**:
  * Pilih **Kategori** dan **Bab** (daftar bab muncul otomatis sesuai kategori).
  * Masukkan **Judul Materi**, **Urutan**, dan status publikasi (**Published** agar tampil ke siswa, atau **Draft** jika belum siap).
  * Susun isi materi menggunakan **Word-Style Dual-Mode Editor** (tersedia pilihan **Mode Standar** & **Mode Luas Layar Penuh**, format teks, penomoran angka/huruf/romawi, anak judul tebal otomatis, kotak catatan berwarna, serta tombol sisip gambar langsung ke dalam artikel).
  * Tambahkan tautan referensi eksternal jika diperlukan, lalu klik **Simpan**.

> *[Sisipkan Screenshot: Halaman Daftar Kelola Materi]*  
> *Gambar 3.16 - Halaman Kelola Materi*

> *[Sisipkan Screenshot: Tampilan Word-Style Dual-Mode Editor Materi]*  
> *Gambar 3.17 - Word-Style Dual-Mode Editor (Tambah / Edit Materi)*

#### 3.3.5 Kelola Quiz & Audio Listening
* Klik menu **Kelola Quiz** pada sidebar.
* Klik **Tambah Quiz**:
  * Pilih **Materi** target.
  * Tulis **Pertanyaan**, **Pilihan A, B, C, D**, tentukan **Kunci Jawaban** (`A/B/C/D`), **Poin**, **Urutan**, dan status (**Aktif / Draft**).
  * Untuk materi *Listening*, unggah berkas audio (`.mp3`/`.wav`), isi judul audio serta petunjuk pengerjaan.
* Seluruh butir soal aktif pada satu materi otomatis tergabung menjadi satu paket kuis bagi siswa.

> *[Sisipkan Screenshot: Halaman Daftar Kelola Quiz]*  
> *Gambar 3.18 - Halaman Kelola Quiz*

> *[Sisipkan Screenshot: Form Tambah Soal Quiz & Unggah Audio]*  
> *Gambar 3.19 - Form Tambah Soal Quiz & Unggah Audio Listening*

#### 3.3.6 Hasil Quiz & Detail Jawaban
* Klik menu **Hasil Quiz** pada sidebar untuk memantau evaluasi ujian siswa.
* Bagian atas menampilkan 3 kartu metrik: **Total Quiz Dikerjakan**, **Rata-rata Nilai**, dan **Rekap Tersimpan** (jumlah lembar hasil kuis yang tersimpan sah di database).
* Gunakan pencarian nama/email/materi, lalu klik tombol **Detail** pada salah satu baris untuk meninjau jumlah jawaban benar, salah, dan opsi jawaban yang dipilih siswa pada setiap soal.

> *[Sisipkan Screenshot: Halaman Rekap Hasil Quiz]*  
> *Gambar 3.20 - Halaman Hasil Quiz (Evaluasi & Rekap Tersimpan)*

> *[Sisipkan Screenshot: Halaman Detail Jawaban Siswa per Soal]*  
> *Gambar 3.21 - Halaman Detail Jawaban Siswa per Soal*

#### 3.3.7 Monitoring Per Siswa
* Klik menu **Monitoring Siswa** pada sidebar.
* Halaman ini menampilkan 5 kartu statistik: **Total Siswa**, **Siswa Aktif**, **Siswa Nonaktif**, **Rata-rata Progress (%)**, dan **Total Poin** semua siswa.
* Klik detail pada salah satu siswa untuk memantau riwayat nilai kuis, materi yang telah diselesaikan, rata-rata nilai individu, serta waktu aktivitas login terakhir.

> *[Sisipkan Screenshot: Halaman Monitoring Per Siswa]*  
> *Gambar 3.22 - Halaman Monitoring Per Siswa*

> *[Sisipkan Screenshot: Halaman Detail Monitoring Satu Siswa]*  
> *Gambar 3.23 - Halaman Detail Monitoring Individu Siswa*

#### 3.3.8 Kirim Reminder & Profil Admin
* Klik menu **Kirim Reminder** untuk mengirimkan pesan pengingat belajar langsung ke siswa tertentu atau seluruh siswa.
* Klik **Profil Saya** untuk mengubah biodata, kata sandi, dan avatar admin.

> *[Sisipkan Screenshot: Halaman Kirim Reminder ke Siswa]*  
> *Gambar 3.24 - Halaman Kirim Reminder ke Siswa*

---

### 3.4 Panduan untuk Siswa

#### 3.4.1 Dashboard Siswa
Setelah login sebagai Siswa, halaman Dashboard menampilkan ringkasan jumlah materi selesai, kuis selesai, rata-rata nilai, total poin, serta daftar bab dan materi belajar yang siap diakses.

> *[Sisipkan Screenshot: Halaman Dashboard Siswa]*  
> *Gambar 3.25 - Dashboard Siswa*

#### 3.4.2 Daftar Materi & Penguncian Berurutan (*Sequential Lock*)
* Klik menu **Materi (`Materi & Quiz`)** pada sidebar.
* **Materi ke-1** di setiap bab selalu terbuka, sedangkan **Materi ke-2 dan seterusnya** berstatus **Terkunci (ikon gembok)** hingga materi sebelumnya selesai tuntas (lulus kuisnya, atau selesai dibaca jika materi tersebut tidak memiliki kuis).

> *[Sisipkan Screenshot: Halaman Daftar Materi dengan status Terbuka dan Terkunci]*  
> *Gambar 3.26 - Halaman Daftar Materi & Status Gembok Sekuensial*

#### 3.4.3 Membaca Materi & *Focus Mode*
* Klik salah satu materi yang terbuka untuk masuk ke halaman baca.
* Status membaca Anda langsung tercatat **Selesai (`Completed`)** dan menaikkan persentase progress belajar Anda.
* Jika materi tersebut memiliki kuis, **Focus Mode** aktif secara otomatis: tombol navigasi keluar dikunci dan Anda wajib menekan tombol **"Lanjut ke Quiz"** di bagian bawah materi setelah selesai membaca.

> *[Sisipkan Screenshot: Halaman Baca Materi dengan banner Focus Mode]*  
> *Gambar 3.27 - Halaman Baca Materi (Focus Mode Aktif)*

#### 3.4.4 Mengerjakan Quiz & Audio Listening
* Klik **"Lanjut ke Quiz"** dari halaman baca materi.
* Perhatikan **Timer Hitung Mundur** di bagian atas layar.
* Jika ada soal *Listening*, tekan tombol **Play** pada pemutar audio untuk mendengarkan rekaman suara.
* Pilih jawaban (`A/B/C/D`), lalu klik **Kumpulkan / Submit Jawaban** sebelum waktu habis (jika waktu habis, jawaban otomatis dikirim oleh sistem).

> *[Sisipkan Screenshot: Halaman Pengerjaan Quiz dengan Timer & Audio Player]*  
> *Gambar 3.28 - Halaman Pengerjaan Quiz & Pemutar Audio Listening*

#### 3.4.5 Hasil Quiz, Pembahasan & Rumus Penilaian
* Tepat setelah menekan **Submit**, skor Anda langsung tampil beserta pembahasan jawaban benar/salah.
* **Aturan Keamanan Soal:** Pembahasan dan kunci jawaban **hanya ditampilkan 1 kali sesaat setelah submit**. Apabila Anda membuka kembali riwayat hasil kuis pada kunjungan berikutnya, sistem hanya menampilkan skor akhir tanpa membocorkan soal maupun kunci jawaban.

##### Tabel 3.1 - Rumus Penilaian Skor, Poin, Rata-rata & Progress
| Metrik | Rumus / Cara Hitung | Keterangan |
| :--- | :--- | :--- |
| **Skor Kuis (0–100)** | `(Jumlah Benar / Total Soal) × 100` *(dibulatkan)* | Murni dari ketepatan jawaban tanpa penalti waktu. |
| **Poin Siswa** | Akumulasi seluruh `skor_diperoleh` siswa | Bertambah setiap kali menuntaskan kuis. |
| **Rata-rata Nilai** | `Total Akumulasi Nilai / Total Kuis Dikerjakan` | Rata-rata performa evaluasi kuis. |
| **Progress Belajar (%)** | `(Materi Completed / Total Materi Aktif) × 100%` | Bertambah otomatis saat membaca materi. |

> *[Sisipkan Screenshot: Halaman Hasil Quiz & Pembahasan Siswa]*  
> *Gambar 3.29 - Halaman Hasil Quiz & Pembahasan (Tampil 1x)*

#### 3.4.6 Peta Quiz & Progress Belajar
* Buka menu **Peta Quiz (`Rute Skor`)** untuk melihat jalur kemajuan kuis per bab/materi.
* Buka menu **Progress Belajar** untuk melihat grafik capaian, riwayat skor kuis, serta lencana prestasi (*Perfect Score*, *Bookworm*, *High Achiever*).

> *[Sisipkan Screenshot: Halaman Peta Quiz Siswa]*  
> *Gambar 3.30 - Halaman Peta Quiz (Rute Skor)*

> *[Sisipkan Screenshot: Halaman Progress Belajar Siswa]*  
> *Gambar 3.31 - Halaman Progress Belajar & Lencana Pencapaian*

#### 3.4.7 Reminder, Notifikasi & Profil Avatar Kucing
* Klik menu **Reminder** atau ikon lonceng di atas untuk membaca pesan dari guru, menandai sudah dibaca, atau menghapus pesan lama.
* Klik menu **Profil** untuk mengubah kata sandi atau memilih salah satu dari **6 Avatar Maskot Kucing Englify** (*Cat Laptop*, *Cat Reading*, *Cat Waving*, *Cat Headphone*, *Cat Trophy*, *Cat Sleepy*).

> *[Sisipkan Screenshot: Halaman Reminder Siswa]*  
> *Gambar 3.32 - Halaman Reminder & Notifikasi Siswa*

> *[Sisipkan Screenshot: Halaman Profil & 6 Pilihan Avatar Kucing Englify]*  
> *Gambar 3.33 - Halaman Profil & Pemilihan 6 Avatar Maskot Kucing*

---

# BAB IV  
# TROUBLESHOOTING (*PEMECAHAN MASALAH*)

### 4.1 Daftar Masalah dan Solusi
Tabel berikut mencantumkan kendala yang paling umum ditemukan saat instalasi maupun penggunaan aplikasi ENGLIFY beserta langkah penyelesaiannya.

#### Tabel 4.1 - Daftar Masalah dan Solusi (*Troubleshooting*)
| No. | Masalah / Error | Penyebab | Solusi |
| :-: | :--- | :--- | :--- |
| **1** | Halaman lokal tidak bisa dibuka / Error `Connection refused` (`2002`) | Layanan MySQL/Apache di XAMPP atau Laragon belum aktif. | Buka XAMPP/Laragon dan jalankan layanan **Apache** dan **MySQL**, lalu akses ulang `http://127.0.0.1:8000`. |
| **2** | Error `SQLSTATE[HY000] [1045] Access denied` | Konfigurasi `DB_USERNAME` atau `DB_PASSWORD` di `.env` tidak cocok. | Buka file `.env`, sesuaikan kredensial database. Untuk XAMPP lokal default: `DB_USERNAME=root`, `DB_PASSWORD=` (kosong). |
| **3** | Error `No application encryption key has been specified` | `APP_KEY` belum di-generate di file `.env`. | Buka terminal di folder proyek, lalu jalankan perintah: `php artisan key:generate`. |
| **4** | Gagal login padahal Email/Username & Password sudah benar | Akun berstatus `nonaktif`, salah ketik spasi/kapital pada password, atau cookie sesi bermasalah. | Pastikan status akun `aktif` melalui Super Admin. Di server hosting HTTPS, pastikan di `.env` nilai `APP_URL=https://...` dan `SESSION_SECURE_COOKIE=true`. |
| **5** | Gambar materi, avatar, atau audio tidak muncul | *Storage symlink* belum dibuat. | Jalankan perintah `php artisan storage:link` dari terminal direktori utama proyek. |
| **6** | Tampilan CSS/JS berantakan di server hosting (*shared hosting*) | Berkas hasil kompilasi Vite (`public/build/`) belum tersedia atau cache belum diperbarui. | Jalankan `npm run build` di komputer lokal lalu unggah folder `public/build/` ke server hosting. |
| **7** | Siswa langsung diarahkan ke `/change-password` setelah login | Fitur keamanan login pertama siswa (`must_change_password = true`) aktif. | Ini bukan error; siswa cukup membuat password baru minimal 6 karakter untuk masuk ke Dashboard. |
| **8** | Tidak bisa mengklik menu sidebar saat membaca materi | Fitur **Focus Mode** sedang mengunci navigasi karena materi memiliki kuis wajib. | Klik tombol **"Lanjut ke Quiz"** di bagian bawah materi dan selesaikan kuisnya sampai selesai. |
| **9** | Muncul halaman **"Basis Data Sedang Tidak Tersedia"** | Koneksi ke server MySQL terputus sementara atau kuota koneksi *shared hosting* sedang penuh (`1040 Too many connections`). | Tunggu beberapa detik lalu klik **"Coba Hubungkan Lagi"**. Untuk pencegahan di *shared hosting*, atur `SESSION_DRIVER=file` di `.env` server. |
| **10** | Error `500 Internal Server Error` | Kesalahan konfigurasi atau kode pada server produksi. | Periksa log kesalahan pada berkas `storage/logs/laravel.log`. Pastikan juga cache rute diperbarui (`php artisan route:clear && php artisan config:clear`). |

---

### 4.2 Tips Pemeliharaan Sistem
* Lakukan **backup database** secara berkala minimal seminggu sekali melalui **phpMyAdmin $\rightarrow$ Export** pada server hosting.
* Pastikan berkas `.env` di lingkungan produksi selalu menggunakan **`APP_DEBUG=false`** agar halaman error SOP tampil rapi dan tidak membocorkan informasi sensitif server.
* Gunakan **`SESSION_DRIVER=file`** di `.env` server *shared hosting* guna menghemat jumlah koneksi database saat banyak siswa mengakses kuis secara bersamaan.
* Periksa dan bersihkan berkas log di `storage/logs/laravel.log` secara berkala apabila ukurannya sudah membesar.
* Ganti kata sandi seluruh akun bawaan (*default seeder*) sebelum aplikasi digunakan di lingkungan kelas nyata.
