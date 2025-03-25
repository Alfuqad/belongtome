<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

$rootDir = "uploads"; // Direktori utama penyimpanan
$currentDir = isset($_GET['dir']) ? $rootDir . "/" . $_GET['dir'] : $rootDir;

// Buat folder utama jika belum ada
if (!file_exists($rootDir)) {
    mkdir($rootDir, 0777, true);
}

// Fungsi untuk membuat folder
// Fungsi untuk mengunggah file
// Fungsi untuk membuat folder baru
if (isset($_POST['create_folder']) && !empty($_POST['folder_name'])) {
    $newFolderName = trim($_POST['folder_name']);
    $newFolderPath = $currentDir . "/" . $newFolderName;

    if (!file_exists($newFolderPath)) {
        mkdir($newFolderPath, 0777, true);
        echo "<script>alert('Folder berhasil dibuat!'); window.location.href='lpb.php?dir=" . $_GET['dir'] . "';</script>";
    } else {
        echo "<script>alert('Folder sudah ada!');</script>";
    }
}


// Fungsi untuk mengunggah file
if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == UPLOAD_ERR_OK) {
    $file = $_FILES['file_upload'];

    // Ambil folder tujuan (jika ada) atau tetap di root
    $targetDir = isset($_GET['dir']) && !empty($_GET['dir']) ? $rootDir . "/" . $_GET['dir'] : $rootDir;

    // Pastikan folder tujuan ada
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Validasi ekstensi file yang diperbolehkan
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx', 'xlsx', 'txt'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "<script>alert('Format file tidak diperbolehkan!');</script>";
        exit;
    }

    // Cegah nama file duplikat dengan menambahkan timestamp
    $safeFileName = pathinfo($file['name'], PATHINFO_FILENAME);
    $safeFileName = preg_replace('/[^a-zA-Z0-9-_]/', '_', $safeFileName);
    $targetFile = $targetDir . "/" . $safeFileName . "_" . time() . "." . $fileExtension;

    // Periksa apakah folder bisa ditulis
    if (!is_writable($targetDir)) {
        echo "<script>alert('Folder tidak dapat ditulisi! Periksa izin.');</script>";
        exit;
    }

    // Pindahkan file yang diunggah
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        echo "<script>alert('File berhasil diunggah!'); window.location.href='lpb.php?dir=" . $_GET['dir'] . "';</script>";
    } else {
        echo "<script>alert('Gagal mengunggah file.');</script>";
    }
} else {
    // Tangani berbagai error saat upload file
    if (isset($_FILES['file_upload']['error'])) {
        switch ($_FILES['file_upload']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "<script>alert('Ukuran file terlalu besar!');</script>";
                break;
            case UPLOAD_ERR_PARTIAL:
                echo "<script>alert('File hanya terunggah sebagian. Coba lagi.');</script>";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "<script>alert('Tidak ada file yang diunggah.');</script>";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo "<script>alert('Server error: folder temp tidak ditemukan.');</script>";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                echo "<script>alert('Gagal menyimpan file di server.');</script>";
                break;
            case UPLOAD_ERR_EXTENSION:
                echo "<script>alert('Upload file diblokir oleh ekstensi PHP.');</script>";
                break;
            default:
                echo "<script>alert('Terjadi kesalahan saat mengunggah file.');</script>";
                break;
        }
    }
}



// Fungsi untuk rename file/folder
if (isset($_POST['rename'])) {
    $oldName = $_POST['old_name'];
    $newName = $_POST['new_name'];
    rename($currentDir . "/" . $oldName, $currentDir . "/" . $newName);
}

// Fungsi untuk menghapus file/folder
if (isset($_POST['delete'])) {
    $target = $currentDir . "/" . $_POST['delete_name'];

    if (is_dir($target)) {
        // Hapus folder beserta isinya
        function deleteFolder($folder)
        {
            foreach (scandir($folder) as $item) {
                if ($item == '.' || $item == '..')
                    continue;
                $itemPath = $folder . DIRECTORY_SEPARATOR . $item;
                is_dir($itemPath) ? deleteFolder($itemPath) : unlink($itemPath);
            }
            // return rmdir($folder); // KOMENTARI DULU
        }
        deleteFolder($target);
    } elseif (file_exists($target)) {
        error_log("Menghapus: " . $target);
        // unlink($target); // KOMENTARI DULU
    }
}


// Dapatkan daftar file dan folder dalam direktori saat ini
$items = scandir($currentDir);
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPB Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

    <!-- ✅ Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">PLN Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="backend/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: linear-gradient(to bottom, #2d5dcc, #1e3a8a);
            color: white;
            padding: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .content {
            margin-left: 260px;
            padding: 20px;
            height: 100vh;
            /* Gunakan tinggi penuh layar */
            overflow-y: auto;
            /* Scroll hanya di dalam main content */
        }

        .table thead {
            background-color: yellow;
        }

        .table tbody td {
            background-color: #d8e9f3;
        }

        .card {
            background: transparent;
            /* Membuat background card transparan */
            border: none;
            /* Menghapus border card */
            box-shadow: none;
            /* Menghapus bayangan card */
        }

        .card-body {
            background: transparent;
            /* Membuat body card juga transparan */
        }
    </style>
    </head>

    <body>

        <!-- Sidebar -->
        <div class="sidebar">
            <a href="jam_nyala.php">⏳ Monitoring</a>
            <a href="lpb.php">📜 Laporan LPB</a>
        </div>

        <!-- ✅ Konten Halaman LPB -->
        <section class="content">
            <h2 class="text-center">Ini adalah halaman LPB</h2>

            <h3>📂 Isi Folder: <?= str_replace($rootDir, "", $currentDir) ?></h3>

            <?php if (isset($_GET['dir']) && $_GET['dir'] != ""): ?>
                <?php
                $currentPath = $_GET['dir'];
                $parentPath = substr($currentPath, 0, strrpos($currentPath, "/"));
                $backLink = empty($parentPath) ? "lpb.php" : "lpb.php?dir=" . $parentPath;
                ?>
                <a href="<?= $backLink ?>" class="btn btn-transparent mb-3">🔙 Kembali</a>

            <?php endif; ?>

            <!-- ✅ Tampilkan Folder dalam Grid -->
            <h3>📂 Folder</h3>
            <div class="row">
                <?php foreach ($items as $item): ?>
                    <?php if ($item != "." && $item != ".." && is_dir($currentDir . "/" . $item)): ?>
                        <div class="col-md-3 mb-3">
                            <div class="d-flex align-items-center justify-content-between bg-light p-3 rounded">
                                <a href="lpb.php?dir=<?= isset($_GET['dir']) ? $_GET['dir'] . "/" . $item : $item ?>"
                                    class="text-decoration-none text-dark">
                                    <span>📁</span> <?= $item ?>
                                </a>
                                <div class="dropdown">
                                    <button class="btn btn-light border-0" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">⋮</button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form method="POST" class="px-3">
                                                <input type="hidden" name="old_name" value="<?= $item ?>">
                                                <input type="text" name="new_name" class="form-control form-control-sm"
                                                    placeholder="Rename">
                                                <button type="submit" name="rename" class="btn btn-sm btn-primary mt-2">Ubah
                                                    Nama</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form method="POST">
                                                <input type="hidden" name="delete_name" value="<?= $item ?>">
                                                <button type="submit" name="delete"
                                                    class="dropdown-item text-danger">Hapus</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div class="row" id="fileContainer">
                <?php foreach ($items as $item): ?>
                    <?php if ($item != "." && $item != ".." && is_file($currentDir . "/" . $item)): ?>
                        <div class="col-md-2 mb-2">
                            <div class="card">
                                <a href="<?= $currentDir . "/" . $item ?>" target="_blank">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg"
                                        class="card-img-top" style="height:50px; object-fit:contain;">
                                </a>
                                <div class="card-body text-center">
                                    <p class="card-text"><?= $item ?></p>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="delete_name" value="<?= $item ?>">
                                        <button type="submit" name="delete" class="btn btn-sm btn-danger">🗑 Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- Tombol Dropdown -->
            <div class="dropdown mb-3">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    ➕ Tambah
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <button class="dropdown-item" onclick="showCreateFolderModal()">
                            📂 Folder baru
                        </button>
                    </li>
                    <!-- Upload File -->
                    <li>
                        <button class="dropdown-item" onclick="document.getElementById('fileUploadInput').click()">
                            📄 Upload file
                        </button>
                        <input type="file" id="fileUploadInput" class="d-none" multiple>
                    </li>

                    <!-- Upload Folder -->
                    <li>
                        <button class="dropdown-item" onclick="document.getElementById('folderUploadInput').click()">
                            📁 Upload folder
                        </button>
                        <input type="file" id="folderUploadInput" class="d-none" name="files[]" webkitdirectory
                            directory multiple onchange="uploadFolder()" />
                    </li>
                </ul>
            </div>

            <!-- Modal Buat Folder -->
            <div class="modal fade" id="createFolderModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">📁 Buat Folder Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" id="folderNameInput" class="form-control" placeholder="Nama Folder"
                                required>
                            <button type="button" onclick="createFolder()" class="btn btn-primary mt-2">Buat</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    updateFileList();

                    let fileInput = document.getElementById("fileUploadInput");
                    if (fileInput) {
                        fileInput.removeEventListener("change", uploadFile); // Hapus dulu jika ada (opsional)
                        fileInput.addEventListener("change", uploadFile); // Tambahkan event listener
                    } else {
                        console.error("Elemen dengan ID 'fileUploadInput' tidak ditemukan.");
                    }
                });

                function updateFileList() {
                    let fileContainer = document.getElementById("fileContainer");
                    if (!fileContainer) {
                        console.error("❌ Elemen fileContainer tidak ditemukan!");
                        return;
                    }

                    fetch("http://localhost/plnmanagement/backend/get_files.php")
                        .then(response => response.json())
                        .then(data => {
                            console.log("🔥 Data dari backend:", data); // Debug hasil dari backend

                            fileContainer.innerHTML = "";

                            // ✅ Perbaiki pengecekan apakah ada file
                            if (!data.files || !Array.isArray(data.files) || data.files.length === 0) {
                                console.warn("⚠ Tidak ada file yang diunggah.");
                                fileContainer.innerHTML = "<p class='text-center'>Tidak ada file yang diunggah.</p>";
                                return;
                            }

                            // ✅ Looping file dengan tampilan card
                            data.files.forEach(file => {
                                let filePath = `http://localhost/plnmanagement/uploads/${file}`; // Sesuaikan path

                                let fileItem = `
                    <div class="col-md-2 mb-2">
                        <div class="card">
                            <a href="${filePath}" target="_blank">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg"
                                    class="card-img-top" style="height:50px; object-fit:contain;">
                            </a>
                            <div class="card-body text-center">
                                <p class="card-text">${file.replace(/^\/+/, '')}</p>
                                <button class="btn btn-sm btn-danger" onclick="deleteFile('${file}')">🗑 Hapus</button>
                            </div>
                        </div>
                    </div>`;
                                fileContainer.innerHTML += fileItem;
                            });
                        })
                        .catch(error => console.error("❌ Error fetching file list:", error));
                }

                async function uploadFile() {
                    let fileInput = document.getElementById("fileUploadInput");
                    if (!fileInput || !fileInput.files.length) {
                        alert("Tidak ada file yang dipilih.");
                        return;
                    }

                    let formData = new FormData();
                    for (let file of fileInput.files) {
                        console.log(`File: ${file.name}`);
                        formData.append("files[]", file); // Pastikan konsisten dengan backend
                    }

                    try {
                        let response = await fetch('backend/upload.php', {
                            method: 'POST',
                            body: formData
                        });

                        let text = await response.text();
                        console.log("Raw response:", text);

                        let data = JSON.parse(text);
                        console.log("Parsed JSON:", data);

                        alert(data.message);
                        if (data.status === "success") {
                            updateFileList(); // Perbarui daftar file setelah upload sukses
                        }
                    } catch (error) {
                        console.error("Upload error:", error);
                        alert("Terjadi kesalahan saat mengunggah file.");
                    }
                }

                function deleteFile(fileName) {
                    let formData = new FormData();
                    formData.append("filename", fileName);

                    fetch("backend/delete_file.php", {
                        method: "POST",
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === "success") {
                                alert("File berhasil dihapus!");
                                updateFileList(); // 🔄 Refresh daftar file
                            } else {
                                alert("Gagal menghapus file: " + data.message);
                            }
                        })
                        .catch(error => console.error("Error deleting file:", error));
                }

                function downloadFile(fileName) {
                    window.location.href = `http://localhost/plnmanagement/backend/download.php?file=${fileName}`;
                }

                function createFolder() {
                    let folderName = document.getElementById("folderName").value;
                    if (folderName.trim() === "") {
                        alert("Nama folder tidak boleh kosong");
                        return;
                    }

                    let formData = new FormData();
                    formData.append("folder_name", folderName);

                    fetch("http://localhost/plnmanagement/backend/create_folder.php", {
                        method: "POST",
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                            updateFileList();
                        })
                        .catch(error => console.error("Error creating folder:", error));
                }

                function uploadFolder() {
                    let folderInput = document.getElementById("folderUploadInput");
                    if (!folderInput || !folderInput.files.length) {
                        alert("Tidak ada folder yang dipilih.");
                        return;
                    }

                    let formData = new FormData();
                    for (let file of folderInput.files) {
                        let relativePath = file.webkitRelativePath;
                        console.log(`File: ${file.name}, Path: ${relativePath}`);
                        formData.append("files[]", file);
                        formData.append("paths[]", relativePath);
                    }

                    fetch("http://localhost/plnmanagement/backend/upload.php", {
                        method: "POST",
                        body: formData
                    })
                        .then(response => response.text())
                        .then(text => {
                            console.log("Server response:", text); // Debugging
                            let data;
                            try {
                                data = JSON.parse(text);
                            } catch (error) {
                                console.error("Response bukan JSON:", text);
                                alert("Terjadi kesalahan: Server tidak mengembalikan JSON yang valid.");
                                return;
                            }

                            if (data.status === "success") {
                                alert("Upload folder berhasil: " + data.message);
                                location.reload();
                            } else {
                                alert("Upload gagal: " + data.message);
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("Upload gagal: " + error.message);
                        });
                }
            </script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>