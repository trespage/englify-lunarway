# 📚 Dokumentasi Spesifikasi REST API — ENGLIFY
**Sistem Pembelajaran Bahasa Inggris Interaktif (UKK 2026)**  
**Peran & Tanggung Jawab:** Siswa 2 (Backend Engineer)  
**Berkas Postman Collection:** [`api_collection.json`](file:///d:/LunarWay-UKK-2026/englify-app/api_collection.json) *(Tersedia di root & folder docs/)*

---

## 1. Ringkasan & Arsitektur API

Dokumentasi ini memuat spesifikasi antarmuka pemrograman aplikasi (Application Programming Interface / API) untuk sistem pembelajaran **ENGLIFY**. API ini dirancang menggunakan standar arsitektur RESTful dengan format pertukaran data JSON terstruktur (*Standard JSON Envelope DTO*).

### Base URL
| Lingkungan | Alamat URL (*Base URL*) |
| :--- | :--- |
| **Lokal (Development)** | `http://localhost:8000` |
| **Hosting (Production)** | `https://[nama-domain-hosting-anda]` |

### Header Permintaan Global (*Global Request Headers*)
Setiap permintaan ke API wajib menyertakan header berikut:
```http
Accept: application/json
Content-Type: application/json
```

---

## 2. Standar Struktur Respon (Standard DTO Envelope)

Seluruh endpoint pada aplikasi ENGLIFY mengembalikan struktur respon seragam guna mempermudah integrasi frontend, aplikasi mobile, maupun pengujian otomatis:

### A. Respon Sukses (HTTP 200 OK)
```json
{
  "status": "success",
  "message": "Pesan deskripsi data berhasil dimuat",
  "data": [...] // Dapat berupa Array data atau Object detail
}
```

### B. Respon Gagal / Akses Ditolak (HTTP 401 / 403 / 404 / 500)
```json
{
  "status": "error",
  "message": "Deskripsi alasan kegagalan / penolakan akses",
  "data": null
}
```

### Daftar Kode Status HTTP (*Status Codes*)
* `200 OK` — Permintaan berhasil diproses.
* `401 Unauthorized` — Pengguna belum login atau token sesi tidak valid.
* `403 Forbidden` — Akses ditolak karena peran (*role*) pengguna tidak berwenang.
* `404 Not Found` — Data atau resource yang dicari tidak ditemukan di database.
* `500 Internal Server Error` — Kendala koneksi server basis data.

---

## 3. Daftar Endpoint Lengkap

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                           KATALOG ENDPOINT API                              │
├─────────────────────────────────────────────────────────────────────────────┤
│ 1. DATA MASTER & KURIKULUM (Publik / Siswa / Tamu):                        │
│    GET  /api/kategori           -> Daftar Kategori Divisi                   │
│    GET  /api/kategori/{id}      -> Detail Kategori & Bab Terkait            │
│    GET  /api/bab                -> Daftar Semua Bab Pembelajaran            │
│    GET  /api/bab/{id}           -> Detail Bab, Materi & Kuis                │
│    GET  /api/materi             -> Daftar Materi Belajar (Published)        │
│    GET  /api/materi/{id}        -> Detail Isi Materi Belajar                │
│    GET  /api/quiz               -> Daftar Soal Kuis (Kunci Terlindungi)     │
│    GET  /api/quiz/{id}          -> Detail Butir Soal Kuis                   │
│    GET  /api/reviews            -> Daftar Testimoni/Ulasan Terverifikasi    │
│                                                                             │
│ 2. DATA MONITORING (Wajib Login: Admin / Super Admin):                      │
│    GET  /api/monitoring         -> Rekap Monitoring Seluruh Siswa           │
│    GET  /api/monitoring/{id}    -> Detail Progres & Riwayat Nilai Siswa     │
│                                                                             │
│ 3. MANAJEMEN PENGGUNA (Wajib Login: Super Admin):                           │
│    GET  /api/users              -> Daftar Seluruh Akun Pengguna             │
│    GET  /api/users/{id}         -> Detail Informasi Akun Pengguna           │
│                                                                             │
│ 4. PROGRESS SISWA (Wajib Login: Siswa Aktif):                              │
│    GET  /api/siswa/progress     -> Ringkasan & Riwayat Progres Pribadi      │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 4. Rincian Spesifikasi Setiap Endpoint

### GRUP 1: DATA MASTER & KURIKULUM

#### 1.1 GET Semua Kategori
* **Endpoint:** `GET /api/kategori`
* **Hak Akses:** Publik (Tamu, Siswa, Admin)
* **Query Parameter:**
  * `q` *(string, opsional)* — Pencarian nama kategori.
* **Contoh Respon:**
```json
{
  "status": "success",
  "message": "Data berhasil dimuat",
  "data": [
    {
      "id_kategori": 1,
      "nama_kategori": "Speaking",
      "deskripsi": "Materi praktik berbicara",
      "materi_count": 5,
      "babs_count": 2
    }
  ]
}
```

#### 1.2 GET Detail Kategori
* **Endpoint:** `GET /api/kategori/{id}`
* **Hak Akses:** Publik
* **Parameter URL:** `id` *(integer, required)* — ID Kategori
* **Contoh Respon:**
```json
{
  "status": "success",
  "message": "Detail kategori berhasil dimuat",
  "data": {
    "id_kategori": 1,
    "nama_kategori": "Speaking",
    "deskripsi": "Materi praktik berbicara",
    "babs": [
      {
        "id": 1,
        "judul": "Bab 1: Everyday Greetings",
        "urutan": 1,
        "materi": [...]
      }
    ]
  }
}
```

#### 1.3 GET Semua Bab
* **Endpoint:** `GET /api/bab`
* **Query Parameter:**
  * `id_kategori` *(integer, opsional)* — Filter per kategori.
  * `q` *(string, opsional)* — Filter pencarian judul bab.
* **Contoh Respon:**
```json
{
  "status": "success",
  "message": "Data berhasil dimuat",
  "data": [
    {
      "id": 1,
      "id_kategori": 1,
      "judul": "Bab 1: Everyday Greetings",
      "urutan": 1,
      "is_active": 1,
      "materi_count": 3,
      "quizzes_count": 3
    }
  ]
}
```

#### 1.4 GET Semua Materi
* **Endpoint:** `GET /api/materi`
* **Query Parameter:**
  * `id_kategori` *(integer, opsional)*
  * `id_bab` *(integer, opsional)*
  * `q` *(string, opsional)*
* **Contoh Respon:**
```json
{
  "status": "success",
  "message": "Data berhasil dimuat",
  "data": [
    {
      "id_materi": 101,
      "judul": "Common Greetings and Leave-Taking",
      "urutan": 1,
      "status": "Published",
      "kategori": {
        "id_kategori": 1,
        "nama_kategori": "Speaking"
      }
    }
  ]
}
```

#### 1.5 GET Semua Soal Kuis
* **Endpoint:** `GET /api/quiz`
* **Query Parameter:**
  * `id_materi` *(integer, opsional)*
  * `id_bab` *(integer, opsional)*
  * `q` *(string, opsional)*
* **Fitur Keamanan:** Kolom `kunci_jawaban` disembunyikan (*hidden*) secara otomatis untuk non-admin guna mencegah kecurangan.
* **Contoh Respon:**
```json
{
  "status": "success",
  "message": "Data berhasil dimuat",
  "data": [
    {
      "id_quiz": 201,
      "id_materi": 101,
      "pertanyaan": "What is the appropriate response to 'Good morning'?",
      "pilihan_a": "Good night",
      "pilihan_b": "Good morning",
      "pilihan_c": "Goodbye",
      "pilihan_d": "See you",
      "poin": 10,
      "status": "Aktif"
    }
  ]
}
```

#### 1.6 GET Reviews Terverifikasi
* **Endpoint:** `GET /api/reviews`
* **Query Parameter:**
  * `limit` *(integer, default 20, max 100)*
* **Contoh Respon:**
```json
{
  "status": "success",
  "message": "Data berhasil dimuat",
  "data": [
    {
      "id": 1,
      "nama": "Ahmad Pratama",
      "rating": 5,
      "komentar": "Materinya sangat menyenangkan dan kuisnya interaktif!",
      "is_approved": true,
      "created_at": "2026-11-05T08:00:00.000000Z"
    }
  ]
}
```

---

### GRUP 2: DATA MONITORING (Role: Admin & Super Admin)

#### 2.1 GET Rekap Monitoring Seluruh Siswa
* **Endpoint:** `GET /api/monitoring`
* **Hak Akses:** `Admin Divisi (2)` & `Super Admin (1)`
* **Query Parameter:**
  * `q` *(string, opsional)* — Cari nama atau email siswa.
  * `status` *(string, opsional)* — `aktif` atau `nonaktif`.
* **Contoh Respon:**
```json
{
  "status": "success",
  "message": "Data berhasil dimuat",
  "data": [
    {
      "id_user": 20,
      "nama": "Budi Santoso",
      "email": "budi@englify.com",
      "status": "aktif",
      "total_quiz_dikerjakan": 8,
      "total_skor": 640,
      "materi_dibaca": 8
    }
  ]
}
```

#### 2.2 GET Detail Monitoring Satu Siswa
* **Endpoint:** `GET /api/monitoring/{id}`
* **Hak Akses:** `Admin Divisi (2)` & `Super Admin (1)`
* **Parameter URL:** `id` *(integer, required)* — ID User Siswa
* **Contoh Respon:**
```json
{
  "status": "success",
  "message": "Detail monitoring siswa berhasil dimuat",
  "data": {
    "siswa": {
      "id_user": 20,
      "nama": "Budi Santoso",
      "email": "budi@englify.com"
    },
    "total_quiz_dikerjakan": 8,
    "total_poin": 640,
    "rata_rata_nilai": 80.0,
    "total_materi_dibaca": 8,
    "riwayat_quiz": [...],
    "progress_materi": [...]
  }
}
```

---

### GRUP 3: MANAJEMEN PENGGUNA (Role: Super Admin)

#### 3.1 GET Semua Pengguna
* **Endpoint:** `GET /api/users`
* **Hak Akses:** `Super Admin (1)`
* **Query Parameter:**
  * `role` *(string/int, opsional)* — `superadmin`, `admin`, `siswa` (1, 2, 3)
  * `status` *(string, opsional)* — `aktif`, `nonaktif`
  * `q` *(string, opsional)* — Pencarian nama / email
* **Contoh Respon:**
```json
{
  "status": "success",
  "message": "Data berhasil dimuat",
  "data": [
    {
      "id_user": 1,
      "nama": "Super Administrator",
      "username": "superadmin",
      "email": "superadmin@englify.com",
      "id_role": 1,
      "status": "aktif",
      "role": {
        "id_role": 1,
        "nama_role": "Super Admin"
      }
    }
  ]
}
```

#### 3.2 GET Detail Pengguna
* **Endpoint:** `GET /api/users/{id}`
* **Hak Akses:** `Super Admin (1)`
* **Parameter URL:** `id` *(integer, required)* — ID User

---

### GRUP 4: PROGRESS SISWA (Role: Siswa Aktif)

#### 4.1 GET Progress Siswa Aktif
* **Endpoint:** `GET /api/siswa/progress`
* **Hak Akses:** Siswa yang sedang terotentikasi (*Authenticated User*)
* **Fungsi:** Mengambil riwayat belajar dan akumulasi nilai akun yang sedang login.
* **Contoh Respon:**
```json
{
  "status": "success",
  "message": "Data berhasil dimuat",
  "data": {
    "total_materi": 16,
    "materi_dibaca": 4,
    "total_quiz": 4,
    "total_skor": 340,
    "riwayat": [
      {
        "id_hasil": 12,
        "id_quiz": 201,
        "skor_diperoleh": 85,
        "created_at": "2026-11-08T14:20:00.000000Z",
        "quiz": {
          "id_quiz": 201,
          "pertanyaan": "What is the appropriate response to 'Good morning'?",
          "materi": {
            "id_materi": 101,
            "judul": "Common Greetings and Leave-Taking"
          }
        }
      }
    ]
  }
}
```

---

## 5. Panduan Penggunaan Berkas Postman (`api_collection.json`)

Berkas koleksi Postman telah disiapkan di root direktori proyek:
📁 `d:\LunarWay-UKK-2026\englify-app\api_collection.json` (dan duplikat di `docs/api_collection.json`).

### Cara Import ke Aplikasi Postman:
1. Buka aplikasi **Postman**.
2. Klik tombol **Import** di pojok kiri atas.
3. Seret (*drag & drop*) berkas `api_collection.json` atau pilih melalui file explorer.
4. Klik **Import**. Koleksi bernama **"ENGLIFY API Collection - UKK 2026"** akan langsung muncul.
5. **Mengatur URL:**
   * Di tab **Variables** pada koleksi, ubah variabel `base_url` sesuai kebutuhan:
     * Pengujian Lokal: `http://localhost:8000`
     * Pengujian Hosting: `https://[nama-domain-anda]`
6. Untuk endpoint yang memerlukan autentikasi (*Monitoring / Users / Progress*), login terlebih dahulu melalui web browser agar cookie sesi tersimpan otomatis di Postman Interceptor / Desktop Agent.

