<?php
// Koneksi ke database
require 'backend/db.php';

// Ambil nilai bulan dan tahun yang dipilih dari form
$selected_month = isset($_GET['bulan']) ? strtolower($_GET['bulan']) : '';
$selected_year = isset($_GET['tahun']) ? $_GET['tahun'] : '';

// Menentukan nama database berdasarkan tahun yang dipilih
$database_name = "pln_db" . $selected_year;
if (!in_array($selected_year, ['2024', '2025'])) {
    $database_name = 'pln_db2025'; // Default ke database terbaru
}

// Menentukan nama tabel berdasarkan bulan dan tahun yang dipilih
if (!empty($selected_month) && !empty($selected_year)) {
    $table_name = "lpb_" . $selected_month . $selected_year;
} else {
    $table_name = "lpb_desember2025"; // Default ke tabel terbaru
}

// Gunakan database yang dipilih
mysqli_select_db($conn, $database_name);

// Ambil total pelanggan
$result_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM $table_name");
$total_pelanggan = mysqli_fetch_assoc($result_total)['total'];

// Ambil jumlah pelanggan yang nyala
$result_nyala = mysqli_query($conn, "SELECT COUNT(*) AS nyala FROM $table_name WHERE KDSWITCHING LIKE '%CA01'");
$nyala = mysqli_fetch_assoc($result_nyala)['nyala'];

// Hitung pelanggan padam
$padam = $total_pelanggan - $nyala;

// Filter Data
$filter_id = isset($_GET['id_pelanggan']) ? $_GET['id_pelanggan'] : '';
$filter_nama = isset($_GET['nama_pelanggan']) ? $_GET['nama_pelanggan'] : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

$query = "SELECT IDPEL, NAMA, TARIP, DAYA, KDSWITCHING FROM $table_name WHERE 1=1";

if (!empty($filter_id)) {
    $query .= " AND IDPEL LIKE '%$filter_id%'";
}
if (!empty($filter_nama)) {
    $query .= " AND NAMA LIKE '%$filter_nama%'";
}
if ($filter_status == 'Nyala') {
    $query .= " AND KDSWITCHING LIKE '%CA01'";
} elseif ($filter_status == 'Padam') {
    $query .= " AND KDSWITCHING NOT LIKE '%CA01'";
}

$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jam Nyala</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- ✅ Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- PLN Management ke kiri -->
            <a class="navbar-brand ms-3" href="dashboard.php">PLN Management</a>

            <!-- Menu Toggler untuk Responsiveness -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Home & Logout ke kanan -->
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto me-3">
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
        }

        .table thead {
            background-color: yellow;
        }

        .table tbody td {
            background-color: #d8e9f3;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="jam_nyala.php">⏳ Monitoring</a>
        <a href="lpb.php">📜 Laporan LPB</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2 class="mb-4">Jam Nyala</h2>

        <!-- Filter Form dalam satu baris dengan desain rapi -->
        <div class="row mb-3 g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">ID Pelanggan</label>
                <input type="text" class="form-control" placeholder="Masukkan ID">
            </div>
            <div class="col-md-3">
                <label class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control" placeholder="Masukkan Nama">
            </div>
            <div class="col-md-3">
                <label class="form-label">Pilih Tanggal</label>
                <input type="date" class="form-control">
            </div>

            <div class="col-md-3 d-grid">
                <button class="btn btn-primary">Cari</button>
            </div>
        </div>
        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Filter Data</title>
            <style>
                .filter-container {
                    display: flex;
                    gap: 20px;
                    margin: 10px 0;
                    align-items: center;
                }

                .filter-label {
                    font-weight: bold;
                    cursor: pointer;
                }

                .filter-group {
                    display: none;
                    flex-direction: column;
                    gap: 5px;
                    margin-top: 5px;
                    padding: 10px;
                    border: 1px solid #ccc;
                    background-color: #f9f9f9;
                    position: absolute;
                    z-index: 1;
                }

                .filter-wrapper {
                    position: relative;
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                }

                .filter-group label {
                    display: flex;
                    align-items: center;
                    gap: 5px;
                }

                .apply-button {
                    margin-left: auto;
                }
            </style>
            <script>
                function toggleFilter(id) {
                    let element = document.getElementById(id);
                    element.style.display = element.style.display === "none" ? "flex" : "none";
                }
            </script>
        </head>

        <body>

            <div class="row mb-3 g-2 align-items-end">
                <!-- Filter Tarif -->
                <div class="col-md-3">
                    <label class="form-label">Pilih Tarif</label>
                    <select class="form-select" id="selectDaya">
                        <option value="">-- Pilih --</option>
                        <option value="450">R1</option>
                        <option value="900">R1M</option>

                    </select>
                </div>

                <!-- Filter Daya -->
                <div class="col-md-3">
                    <label class="form-label">Pilih Daya</label>
                    <select class="form-select" id="selectDaya">
                        <option value="">-- Pilih --</option>
                        <option value="450">450</option>
                        <option value="900">900</option>
                        <option value="1300">1300</option>
                    </select>
                </div>

                <!-- Filter Status -->
                <div class="col-md-3">
                    <label class="form-label">Pilih Status</label>
                    <select class="form-select" id="selectStatus">
                        <option value="">-- Pilih --</option>
                        <option value="Nyala">Nyala</option>
                        <option value="Mati">Mati</option>
                    </select>
                </div>

                <!-- Tombol Terapkan -->
                <div class="col-md-3 d-grid">
                    <button class="btn btn-primary" onclick="applyFilters()">Terapkan</button>
                </div>
            </div>



            <script>
                function applyFilters() {
                    let tarif = [];
                    document.querySelectorAll('input[name="tarif"]:checked').forEach((el) => {
                        tarif.push(el.value);
                    });

                    let daya = document.querySelector('input[name="daya"]:checked')?.value || "";
                    let status = document.querySelector('input[name="status"]:checked')?.value || "";

                    let message = "Filter Diterapkan:\n";
                    if (tarif.length > 0) message += "Tarif: " + tarif.join(", ") + "\n";
                    if (daya) message += "Daya: " + daya + "\n";
                    if (status) message += "Status: " + status + "\n";

                    if (message === "Filter Diterapkan:\n") {
                        message = "Tidak ada filter yang dipilih.";
                    }

                    alert(message);
                }

                document.querySelectorAll('input[type="radio"]').forEach((el) => {
                    el.addEventListener('click', function (event) {
                        if (this.checked) {
                            this.dataset.wasChecked = this.dataset.wasChecked === "true" ? "false" : "true";
                            if (this.dataset.wasChecked === "false") {
                                this.checked = false;
                            }
                        }
                    });
                });
            </script>
        </body>

        </html>



        <!-- Data Table -->
        <table id="jamNyalaTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Pelanggan</th>
                    <th>Nama</th>
                    <th>Tarif</th>
                    <th>Daya</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) {
                    $status = (strpos($row['KDSWITCHING'], 'CA01') !== false) ?
                        "<span class='badge bg-success'>Nyala</span>" :
                        "<span class='badge bg-danger'>Padam</span>";
                    echo "<tr>
                            <td>{$row['IDPEL']}</td>
                            <td>{$row['NAMA']}</td>
                            <td>{$row['TARIP']}</td>
                            <td>{$row['DAYA']}</td>
                            <td>{$status}</td>
                          </tr>";
                } ?>
            </tbody>
        </table>


        <!-- Copyright -->
        <p class="text-center mt-4">&copy; 2025 PLN Data Management | All Rights Reserved.</p>
    </div>

    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#jamNyalaTable').DataTable();
        });
    </script>

</body>

</html>