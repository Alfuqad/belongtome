<?php
include 'db.php';
require __DIR__ . '/../vendor/autoload.php'; // Load PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$response = ["status" => "error", "message" => "Gagal mengunggah file"];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }

    if (!isset($_FILES['files'])) {
        throw new Exception("Variabel \$_FILES['files'] tidak tersedia.");
    }

    if (empty($_FILES['files']['name'][0])) {
        throw new Exception("Nama file kosong, kemungkinan file tidak dikirim.");
    }

    foreach ($_FILES['files']['name'] as $i => $filename) {
        if (empty($filename)) {
            throw new Exception("Nama file kosong di indeks $i.");
        }
    }

    $target_dir = __DIR__ . "/uploads/";

    foreach ($_FILES['files']['name'] as $i => $filename) {
        $filename = basename($filename);
        $file_tmp = $_FILES['files']['tmp_name'][$i];
        $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $allowed_extensions = ['xls', 'xlsx'];
        if (!in_array($filetype, $allowed_extensions)) {
            throw new Exception("Format file tidak diizinkan: $filename.");
        }

        $relative_path = $_POST['paths'][$i] ?? $filename;
        $target_file = $target_dir . $relative_path;

        $folder_path = dirname($target_file);
        if (!is_dir($folder_path)) {
            mkdir($folder_path, 0777, true);
        }

        if (file_exists($target_file)) {
            unlink($target_file);
        }

        if (!move_uploaded_file($file_tmp, $target_file)) {
            throw new Exception("Gagal mengunggah file: $filename.");
        }

        $spreadsheet = IOFactory::load($target_file);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        if (empty($data) || !isset($data[0]) || !is_array($data[0])) {
            throw new Exception("File Excel $filename tidak memiliki data atau formatnya salah.");
        }

        // 🔍 **Cari Bulan & Tahun dari Nama File**
        $tahun = null;
        $bulan = null;

        if (preg_match('/\b(20\d{2})(0[1-9]|1[0-2])\d{2}\b/', $filename, $matches)) {
            $tahun = $matches[1];
            $bulan = (int) $matches[2];
        }

        // 🔍 **Jika tidak ditemukan, cek dalam data Excel**
        if (!$tahun || !$bulan) {
            foreach ($data as $row) {
                foreach ($row as $cell) {
                    if (!empty($cell) && preg_match('/\b(20\d{2})-(0[1-9]|1[0-2])/', $cell, $match_tanggal)) {
                        $tahun = $match_tanggal[1];
                        $bulan = (int) $match_tanggal[2];
                        break 2;
                    }
                }
            }
        }

        // 🔥 **Jika bulan/tahun masih tidak ditemukan, hentikan proses**
        if (!$tahun || !$bulan) {
            throw new Exception("Bulan atau tahun tidak ditemukan dalam file: $filename.");
        }

        // 🔄 **Konversi angka bulan ke nama bulan**
        $nama_bulan = [
            1 => "januari",
            2 => "februari",
            3 => "maret",
            4 => "april",
            5 => "mei",
            6 => "juni",
            7 => "juli",
            8 => "agustus",
            9 => "september",
            10 => "oktober",
            11 => "november",
            12 => "desember"
        ];

        $dbname = "pln_db" . $tahun;
        $table_name = "lpb_" . $nama_bulan[$bulan] . $tahun;

        $conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
        $conn->select_db($dbname);

        // **Buat atau update tabel di database**
        $columns = array_map(fn($col) => preg_replace('/[^a-zA-Z0-9_]/', '_', strtoupper($col)), $data[0]);
        $column_definitions = implode(", ", array_map(fn($col) => "`$col` TEXT", $columns));

        $check_table = $conn->query("SHOW TABLES FROM $dbname LIKE '$table_name'");
        if ($check_table->num_rows == 0) {
            $create_table_sql = "CREATE TABLE `$table_name` (id INT AUTO_INCREMENT PRIMARY KEY, $column_definitions)";
            if (!$conn->query($create_table_sql)) {
                throw new Exception("Gagal membuat tabel: " . $conn->error);
            }
        }

        // **Masukkan data ke dalam tabel**
        $column_names = implode(", ", array_map(fn($col) => "`$col`", $columns));
        $placeholders = implode(", ", array_fill(0, count($columns), "?"));
        $sql = "INSERT INTO `$table_name` ($column_names) VALUES ($placeholders)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Kesalahan database: " . $conn->error);
        }

        foreach ($data as $index => $row) {
            if ($index == 0)
                continue;
            $stmt->bind_param(str_repeat("s", count($columns)), ...$row);
            $stmt->execute();
        }
    }

    $response = ["status" => "success", "message" => "Semua file berhasil diunggah dan diproses!"];
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    file_put_contents("error_log.txt", date("Y-m-d H:i:s") . " - " . $e->getMessage() . "\n", FILE_APPEND);

    http_response_code(500);
    $response = ["status" => "error", "message" => $e->getMessage()];
}

echo json_encode($response);
?>