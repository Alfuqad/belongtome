<?php
header("Content-Type: application/json");

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Metode tidak didukung.");
    }

    if (!isset($_POST['filename'])) {
        throw new Exception("Nama file tidak diberikan.");
    }

    $filename = $_POST['filename'];
    $folder = "uploads/"; // Sesuaikan dengan folder tempat file disimpan
    $filepath = __DIR__ . "/../" . $folder . $filename;

    // Periksa apakah file ada di folder sebelum dihapus
    if (!file_exists($filepath)) {
        throw new Exception("File tidak ditemukan di server: $filename.");
    }

    // Hapus file dari folder
    if (!unlink($filepath)) {
        throw new Exception("Gagal menghapus file: $filename.");
    }

    error_log("🗑 File berhasil dihapus: " . $filepath);

    echo json_encode(["status" => "success", "message" => "File berhasil dihapus dari folder!"]);
} catch (Exception $e) {
    error_log("⛔ ERROR: " . $e->getMessage());
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>