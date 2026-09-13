<?php
/**
 * api.php
 *
 * File ini berperan ganda sesuai kebutuhan tugas:
 * 1. REST SERVER  -> menyediakan endpoint (GET /api.php?adm4=...) yang bisa
 *    dipanggil oleh frontend (atau aplikasi lain) dan mengembalikan JSON.
 * 2. REST CLIENT  -> di dalam endpoint tersebut, server ini memanggil REST API
 *    publik milik BMKG (https://api.bmkg.go.id) untuk mengambil data
 *    prakiraan cuaca, lalu meneruskan hasilnya ke pemanggil.
 *
 * Sumber data: BMKG (Badan Meteorologi, Klimatologi, dan Geofisika)
 * https://data.bmkg.go.id/prakiraan-cuaca
 */

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

// Kode wilayah tingkat IV (kelurahan/desa) dari BMKG.
// Contoh default: Kel. Gambir, Jakarta Pusat (31.71.01.1001)
// Kode wilayah lain bisa dicari di https://data.bmkg.go.id/prakiraan-cuaca
$adm4 = isset($_GET['adm4']) ? trim($_GET['adm4']) : '31.71.01.1001';

// Validasi sederhana format kode wilayah (contoh: 31.71.01.1001)
if (!preg_match('/^\d{2}\.\d{2}\.\d{2}\.\d{4}$/', $adm4)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Format kode wilayah tidak valid. Contoh yang benar: 31.71.01.1001"
    ]);
    exit;
}

$apiUrl = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=" . urlencode($adm4);

// ---- Bagian REST CLIENT: memanggil API BMKG menggunakan cURL ----
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_USERAGENT, "cuaca-rest-client/1.0 (Tugas Pemrograman Terdistribusi)");
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($response === false || $httpCode !== 200) {
    http_response_code(502);
    echo json_encode([
        "success" => false,
        "message" => "Gagal mengambil data dari API BMKG.",
        "detail" => $curlError ?: "HTTP status: $httpCode"
    ]);
    exit;
}

$data = json_decode($response, true);

if ($data === null) {
    http_response_code(502);
    echo json_encode([
        "success" => false,
        "message" => "Respons dari API BMKG bukan format JSON yang valid."
    ]);
    exit;
}

// ---- Bagian REST SERVER: meneruskan data yang sudah diproses ke frontend ----
echo json_encode([
    "success" => true,
    "sumber" => "BMKG (Badan Meteorologi, Klimatologi, dan Geofisika)",
    "lokasi" => $data["lokasi"] ?? null,
    "cuaca" => $data["data"][0]["cuaca"] ?? []
]);
