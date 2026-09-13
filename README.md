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

