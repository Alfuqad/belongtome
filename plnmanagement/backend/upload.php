<?php
include 'db.php';
require __DIR__ . '/../vendor/autoload.php'; // Load PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

// Set header agar response berupa JSON
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$response = ["status" => "error", "message" => "Gagal mengunggah file"];

try {
    // Pastikan request adalah POST dan ada file yang diunggah
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['file'])) {
        throw new Exception("Invalid request or no file uploaded.");
    }

    // Ambil folder tujuan
    $folder = isset($_POST['folder']) ? $_POST['folder'] . '/' : '';
    $target_dir = "uploads/" . $folder;

    // Buat folder jika belum ada
    if (!is_dir($target_dir) && !mkdir($target_dir, 0777, true) && !is_dir($target_dir)) {
        throw new Exception("Failed to create directory.");
    }

    $file = $_FILES["file"];
    $filename = basename($file["name"]);
    $filetype = pathinfo($filename, PATHINFO_EXTENSION);
    $target_file = $target_dir . $filename;

    // Cek apakah file berhasil dipindahkan
    if (!move_uploaded_file($file["tmp_name"], $target_file)) {
        throw new Exception("File upload failed.");
    }

    // Jika file adalah Excel, lakukan pemrosesan
    if (in_array(strtolower($filetype), ['xls', 'xlsx'])) {
        $spreadsheet = IOFactory::load($target_file);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        // Pastikan file memiliki data
        if (empty($data) || !isset($data[0]) || !is_array($data[0])) {
            throw new Exception("File Excel tidak memiliki data atau formatnya salah.");
        }

        // Ambil nama file tanpa ekstensi sebagai nama tabel (dengan pembersihan karakter)
        $table_name = pathinfo($filename, PATHINFO_FILENAME);
        $table_name = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower($table_name)); // Pastikan aman untuk SQL

        if (empty($table_name)) {
            throw new Exception("Nama tabel tidak valid atau kosong.");
        }

        // Definisi kolom dari header Excel
        $columns = array_map(fn($col) => preg_replace('/[^a-zA-Z0-9_]/', '_', strtoupper($col)), $data[0]);

        // Cek apakah tabel sudah ada
        $check_table = $conn->query("SHOW TABLES LIKE '$table_name'");
        if ($check_table->num_rows == 0) {
            // Buat tabel dengan jumlah kolom sesuai header file Excel
            $column_definitions = implode(", ", array_map(fn($col) => "`$col` TEXT", $columns));
            $create_table_sql = "CREATE TABLE `$table_name` (id INT AUTO_INCREMENT PRIMARY KEY, $column_definitions)";

            if (!$conn->query($create_table_sql)) {
                throw new Exception("Gagal membuat tabel: " . $conn->error);
            }
        }

        // Masukkan data dari Excel ke tabel yang baru dibuat
        $column_names = implode(", ", array_map(fn($col) => "`$col`", $columns));
        $placeholders = implode(", ", array_fill(0, count($columns), "?"));
        $sql = "INSERT INTO `$table_name` ($column_names) VALUES ($placeholders)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Database error: " . $conn->error);
        }

        foreach ($data as $index => $row) {
            if ($index == 0)
                continue; // Lewati header
            $stmt->bind_param(str_repeat("s", count($columns)), ...$row);
            $stmt->execute();
        }
    }

    $response = ["status" => "success", "message" => "File berhasil diunggah dan diproses!"];
} catch (Exception $e) {
    http_response_code(500);
    $response = ["status" => "error", "message" => $e->getMessage()];
}

echo json_encode($response);
?>