# Cek Prakiraan Cuaca - Tugas Akhir Pemrograman Terdistribusi

Aplikasi web sederhana untuk menampilkan prakiraan cuaca berdasarkan kode
wilayah, dengan memanfaatkan REST API publik milik BMKG (Badan Meteorologi,
Klimatologi, dan Geofisika).

## Konsep / Pemanfaatan REST API

Project ini sekaligus berperan sebagai **REST server** dan **REST client**:

- **REST Client**  `api.php` memanggil REST API publik BMKG
  (`https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=...`) menggunakan cURL
  untuk mengambil data prakiraan cuaca.
- **REST Server**  `api.php` sendiri menyediakan endpoint
  (`GET /api.php?adm4=<kode_wilayah>`) yang mengembalikan response JSON,
  yang kemudian dikonsumsi oleh frontend (`index.html`) menggunakan
  `fetch()`. Endpoint ini juga bisa dipanggil dari aplikasi lain (Postman,
  aplikasi mobile, dsb).

Alurnya:

```
Frontend (index.html)
    -> fetch()
        -> api.php  (REST server)
            -> cURL
                -> API BMKG  (api.php bertindak sebagai REST client)
```

## Cara Menjalankan

1. Pastikan PHP sudah terinstall (versi 7.4 ke atas). Kalau sudah pernah
   pakai Laravel/XAMPP/Laragon, PHP-nya sudah otomatis tersedia.
2. Buka terminal di folder project ini, lalu jalankan:
   ```
   php -S localhost:8000
   ```
3. Buka browser ke `http://localhost:8000`
4. Masukkan kode wilayah tingkat IV (kelurahan/desa), contoh:
   `31.71.01.1001` (Kel. Gambir, Jakarta Pusat), lalu klik **Cek Cuaca**.
5. Kode wilayah lain bisa dicari di
   <https://data.bmkg.go.id/prakiraan-cuaca>

## Struktur File

- `index.html`  frontend sederhana (form input + tampilan hasil)
- `api.php`  backend yang menjadi REST server sekaligus REST client
- `README.md`  dokumen ini

## Sumber Data

Data prakiraan cuaca bersumber dari BMKG (Badan Meteorologi, Klimatologi,
dan Geofisika) melalui API publik <https://data.bmkg.go.id/prakiraan-cuaca>.
Wajib dicantumkan sebagai sumber data sesuai ketentuan BMKG.

## Catatan Pengembangan

- Kode ini dites secara manual (tanpa akses internet saat pembuatan), jadi
  disarankan untuk dicoba jalankan dulu sebelum direkam videonya, siapa
  tahu ada penyesuaian kecil yang diperlukan (misalnya field response API
  BMKG berubah sewaktu-waktu).
- Validasi kode wilayah masih sederhana (format regex). Bisa dikembangkan
  lebih lanjut misalnya dengan dropdown pilihan wilayah, cache hasil
  request, atau penanganan error yang lebih detail.

## Panduan Submit Tugas

1. **Source code**  upload folder ini ke GitHub (buat repository baru,
   push semua file), lalu salin link repository-nya.
2. **Video demo**  rekam layar (screen record) singkat yang menunjukkan:
   - Menjalankan server (`php -S localhost:8000`)
   - Membuka aplikasi di browser
   - Mengisi kode wilayah dan menekan tombol "Cek Cuaca"
   - Hasil prakiraan cuaca yang muncul
   - (opsional) tunjukkan sekilas isi `api.php` sambil dijelaskan bagian
     REST client & REST server-nya
3. Upload video ke Google Drive, ubah izin akses jadi
   **"Anyone with the link can view"**, lalu salin link-nya untuk
   dikumpulkan bersama link GitHub.
