<?php
// Koneksi ke database
require 'backend/db.php';

// Ambil nilai tanggal yang dipilih dari form
$tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : '';
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '';

// Tentukan database dan tabel berdasarkan tanggal
if (!empty($tanggal_awal)) {
    $selected_year = date('Y', strtotime($tanggal_awal));
    $selected_month = strtolower(date('F', strtotime($tanggal_awal)));
} else {
    $selected_year = date('Y');
    $selected_month = strtolower(date('F'));
}

$database_name = "pln_db" . $selected_year;
if (!in_array($selected_year, ['2024', '2025'])) {
    $database_name = 'pln_db2025';
}

$table_name = "lpb_" . $selected_month . $selected_year;

mysqli_select_db($conn, $database_name);

// Check if table exists, if not, use default table
$table_check = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");
if (mysqli_num_rows($table_check) == 0) {
    // If table doesn't exist, use default table (e.g., lpb_desember2025)
    $table_name = "lpb_desember2025";
    // Check if default table exists
    $default_check = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");
    if (mysqli_num_rows($default_check) == 0) {
        // If default table also doesn't exist, show error message
        die("Tabel yang diperlukan tidak ditemukan. Silakan hubungi administrator.");
    }
}

$filter_id = isset($_GET['id_pelanggan']) ? $_GET['id_pelanggan'] : '';
$filter_nama = isset($_GET['nama_pelanggan']) ? $_GET['nama_pelanggan'] : '';
$filter_tarif = isset($_GET['tarif']) ? (array) $_GET['tarif'] : [];
$filter_daya = isset($_GET['daya']) ? (array) $_GET['daya'] : [];

$query = "SELECT IDPEL, NAMA, TARIP, DAYA, TGLBAYAR, PEMKWH, RPPENJ FROM $table_name WHERE 1=1";

// Tambahkan filter tanggal jika ada
if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
    $query .= " AND TGLBAYAR BETWEEN '" . mysqli_real_escape_string($conn, $tanggal_awal) . "' AND '" . mysqli_real_escape_string($conn, $tanggal_akhir) . "'";
}

if (!empty($filter_id)) {
    $query .= " AND IDPEL LIKE '%" . mysqli_real_escape_string($conn, $filter_id) . "%'";
}
if (!empty($filter_nama)) {
    $query .= " AND NAMA LIKE '%" . mysqli_real_escape_string($conn, $filter_nama) . "%'";
}
if (!empty($filter_tarif)) {
    $tarif_in = "'" . implode("','", array_map(function ($item) use ($conn) {
        return mysqli_real_escape_string($conn, $item);
    }, $filter_tarif)) . "'";
    $query .= " AND TARIP IN ($tarif_in)";
}
if (!empty($filter_daya)) {
    $daya_in = "'" . implode("','", array_map(function ($item) use ($conn) {
        return mysqli_real_escape_string($conn, $item);
    }, $filter_daya)) . "'";
    $query .= " AND DAYA IN ($daya_in)";
}

// Modify query to show only unique records per customer (IDPEL)
$query = "SELECT IDPEL, 
          MAX(NAMA) as NAMA, 
          MAX(TARIP) as TARIP, 
          MAX(DAYA) as DAYA, 
          MIN(TGLBAYAR) as TGLBAYAR,
          SUM(PEMKWH) as PEMKWH,
          SUM(RPPENJ) as RPPENJ,
          COUNT(*) as Total_Pembelian
          FROM ($query) as filtered_data
          GROUP BY IDPEL
          ORDER BY TGLBAYAR ASC";

$result = mysqli_query($conn, $query);

// Ambil total pelanggan (after filtering)
$result_total = mysqli_query($conn, "SELECT COUNT(DISTINCT IDPEL) AS total FROM ($query) AS filtered");
$total_pelanggan = mysqli_fetch_assoc($result_total)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jam Nyala</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />
    
    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

/* Sidebar Styling */
.sidebar {
    width: 250px;
    background-color: #f8f9fa;
    padding-top: 20px;
    padding-left: 10px;
    padding-right: 10px;
    position: fixed;
    top: 56px; /* Height of navbar */
    left: 0;
    bottom: 0;
    overflow-y: auto; /* Enable scrolling if content exceeds height */
    z-index: 1000;
}

/* Styling untuk daftar menu */
.sidebar-menu {
    list-style: none;
    padding: 0;
}

/* Styling untuk setiap item */
.sidebar-item {
    margin-bottom: 10px;
}

/* Styling untuk link */
.sidebar-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    padding: 12px;
    border-radius: 8px;
    font-weight: bold;
    color: #333;
    background-color: transparent;
    transition: 0.3s;
}

.sidebar-link i {
    -size: 20px;
    margin-right: 10px;
}

/* Efek hover */
.sidebar-link:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

/* Item aktif (terpilih) */
.sidebar-item.active .sidebar-link {
    background-color: white;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
}


        /* Navbar */
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #ddd;
            position: fixed; /* Make navbar fixed */
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030; /* Ensure navbar stays on top */
        }

        .navbar-brand {
            color: #0056b3;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            color: #333;
            font-weight: bold;
        }

        .navbar-nav .nav-link[href*="logout"] {
            color: red !important;
            /* Khusus Logout tetap merah */
        }

        .navbar-nav .nav-link:hover {
            color: #0056b3;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
            margin-top: 56px; /* Add margin top to account for navbar */
            height: calc(100vh - 56px); /* Full height minus navbar height */
            overflow-y: auto; /* Enable scrolling for main content */
        }

        .table thead {
            background-color: yellow;
        }

        .table tbody td {
            background-color: #d8e9f3;
        }

        #jamNyalaSlider .noUi-connect {
            background: #2196f3;
        }
        #jamNyalaSlider .noUi-handle {
            border-radius: 50%;
            background: #2196f3;
            border: none;
            box-shadow: none;
            width: 16px;
            height: 16px;
            top: 1px;
        }
        #jamNyalaSlider .noUi-handle:before,
        #jamNyalaSlider .noUi-handle:after {
            height: 10px;
            width: 2px;
            top: 4px;
            left: 7px;
        }
        #jamNyalaSlider .noUi-base,
        #jamNyalaSlider .noUi-connect {
            height: 4px;
            top: 50%;
            transform: translateY(-50%);
        }
        #jamNyalaSlider .noUi-horizontal {
            height: 18px;
        }
        #jamNyalaSlider .noUi-touch-area {
            display: none !important;
        }
        #jamNyalaSlider {
            padding: 0 10px;
            box-sizing: border-box;
        }
        #jamNyalaSlider .noUi-handle {
            width: 14px;
            height: 14px;
            top: 2px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand ms-3" href="dashboard.php">PLN Management</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="backend/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li class="sidebar-item <?php echo basename($_SERVER['PHP_SELF']) == 'jam_nyala.php' ? 'active' : ''; ?>">
                <a href="jam_nyala.php" class="sidebar-link">
                    <i class="bi bi-house-door-fill" style="color: #007bff;"></i>
                    <span>Monitoring</span>
                </a>
            </li>
            <li class="sidebar-item <?php echo basename($_SERVER['PHP_SELF']) == 'lpb.php' ? 'active' : ''; ?>">
                <a href="lpb.php" class="sidebar-link">
                    <i class="bi bi-person-circle" style="color: #6c63ff;"></i>
                    <span>LPB</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2 class="mb-4">Jam Nyala</h2>

        <!-- Filter Form -->
        <form method="GET" action="">
            <div class="row mb-3 g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">ID Pelanggan</label>
                    <input type="text" class="form-control" name="id_pelanggan" placeholder="Masukkan ID"
                        value="<?= htmlspecialchars($filter_id) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" name="nama_pelanggan" placeholder="Masukkan Nama"
                        value="<?= htmlspecialchars($filter_nama) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pilih Tanggal</label>
                    <input type="text" class="form-control" id="filterTanggal" name="filterTanggal" readonly placeholder="Pilih tanggal...">
                    <input type="hidden" name="tanggal_awal" id="tanggal_awal">
                    <input type="hidden" name="tanggal_akhir" id="tanggal_akhir">
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>

            <div class="row mb-3 g-2 align-items-end">
                <!-- Filter Tarif -->
                <div class="col-md-3">
                    <label class="form-label">Pilih Tarif</label>
                    <div class="custom-multiselect" id="tarifSelect">
                        <div class="selected" onclick="toggleDropdown('tarifSelect')">
                            <?= !empty($filter_tarif) ? implode(', ', $filter_tarif) : '-- Pilih --' ?>
                        </div>
                        <div class="dropdown">
                            <?php 
                            $tarif_options = ['R1', 'R1M', 'B2', 'R2', 'B1', 'R3', 'S2', 'P3', 'P1', 'L', 'I1'];
                            foreach ($tarif_options as $option): ?>
                                <label>
                                    <input type="checkbox" name="tarif[]" value="<?= $option ?>" 
                                        <?= in_array($option, $filter_tarif) ? 'checked' : '' ?>
                                        onclick="updateSelectedText('tarifSelect')">
                                    <?= $option ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Filter Daya -->
                <div class="col-md-3">
                    <label class="form-label">Pilih Daya</label>
                    <div class="custom-multiselect" id="dayaSelect">
                        <div class="selected" onclick="toggleDropdown('dayaSelect')">
                            <?= !empty($filter_daya) ? implode(', ', $filter_daya) : '-- Pilih --' ?>
                        </div>
                        <div class="dropdown">
                            <?php 
                            $daya_options = ['450', '900', '1300', '2200', '3500', '4400', '5500', '6600', '7700', '10600', '11000', '13200', '16500', '23000', '33000'];
                            foreach ($daya_options as $option): ?>
                                <label>
                                    <input type="checkbox" name="daya[]" value="<?= $option ?>" 
                                        <?= in_array($option, $filter_daya) ? 'checked' : '' ?>
                                        onclick="updateSelectedText('dayaSelect')">
                                    <?= $option ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Filter Jam Nyala (Range UI mirip date range) -->
                <div class="col-md-3">
                    <label class="form-label mb-1" style="font-size: 0.95em; margin-bottom: 4px;">Range Jam Nyala (jam)</label>
                    <div class="d-flex justify-content-between align-items-center mb-1" style="gap: 6px;">
                        <input type="number" min="0" max="1000" id="jamNyalaInputMin" class="form-control form-control-sm" style="width: 45%; height:32px;" value="<?= isset($_GET['jam_nyala_min']) ? htmlspecialchars($_GET['jam_nyala_min']) : 0 ?>">
                        <input type="number" min="0" max="1000" id="jamNyalaInputMax" class="form-control form-control-sm" style="width: 45%; height:32px;" value="<?= isset($_GET['jam_nyala_max']) ? htmlspecialchars($_GET['jam_nyala_max']) : 1000 ?>">
                    </div>
                    <div id="jamNyalaSlider" style="margin-top:0.2rem;margin-bottom:0.2rem;"></div>
                    <div class="d-flex justify-content-between" style="font-size: 0.9em; color: #666;">
                        <span>0</span>
                        <span>1000</span>
                    </div>
                    <input type="hidden" name="jam_nyala_min" id="jam_nyala_min" value="<?= isset($_GET['jam_nyala_min']) ? htmlspecialchars($_GET['jam_nyala_min']) : 0 ?>">
                    <input type="hidden" name="jam_nyala_max" id="jam_nyala_max" value="<?= isset($_GET['jam_nyala_max']) ? htmlspecialchars($_GET['jam_nyala_max']) : 1000 ?>">
                </div>

                <!-- Export Button -->
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-success" formmethod="POST" formaction="system.php">
                        <i class="bi bi-file-earmark-excel"></i> Export to Excel
                        <input type="hidden" name="action" value="export_excel">
                        <input type="hidden" name="tanggal" id="export_tanggal">
                    </button>
                </div>
            </div>
        </form>

        <!-- Data Table -->
        <table id="jamNyalaTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Pelanggan</th>
                    <th>Nama</th>
                    <th>Tarif</th>
                    <th>Daya</th>
                    <th>Jam Nyala</th>
                    <th>PEMKWH</th>
                    <th>RPPENJ</th>
                    <th>TGLBAYAR</th>
                    <th>Total Pembelian</th>
                </tr>
            </thead>
        </table>
    </div>

    <style>
        .custom-multiselect {
            position: relative;
            display: inline-block;
            width: 100%;
            vertical-align: middle;
        }

        .custom-multiselect .selected {
            border: 1px solid #ccc;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            background-color: #fff;
            min-height: 32px;
            font-size: 0.95em;
            line-height: 1.5;
            box-sizing: border-box;
            width: 100%;
            margin-bottom: 0;
            /* Tambahkan agar mirip form-control-sm */
        }

        .custom-multiselect .dropdown {
            display: none;
            position: absolute;
            background-color: #fff;
            width: 100%;
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
            z-index: 100;
            padding: 5px 0 5px 0;
            margin-top: 2px;
        }

        .custom-multiselect.open .dropdown {
            display: block;
        }

        .custom-multiselect .dropdown label {
            display: block;
            margin-bottom: 5px;
            padding-left: 8px;
            font-size: 0.95em;
        }
    </style>

    <script>
        function toggleDropdown(id) {
            const el = document.getElementById(id);
            el.classList.toggle("open");
        }

        document.addEventListener("click", function (e) {
            ['tarifSelect', 'dayaSelect'].forEach(id => {
                const container = document.getElementById(id);
                if (!container.contains(e.target)) {
                    container.classList.remove("open");
                    updateSelectedText(container);
                }
            });
        });

        function updateSelectedText(container) {
            const checkboxes = container.querySelectorAll('input[type="checkbox"]');
            const selectedDiv = container.querySelector('.selected');
            const selected = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);

            if (selected.length === 0) {
                selectedDiv.innerText = "-- Pilih --";
            } else if (selected.length === 1) {
                selectedDiv.innerText = selected[0];
            } else {
                selectedDiv.innerText = `${selected.length} selected`;
            }
        }

        // Initialize DataTables with server-side processing
        $(document).ready(function () {
            // Set today's date
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;
            $('#tanggal').val(today);

            var table = $('#jamNyalaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'get_monitoring_data.php',
                    type: 'POST',
                    data: function(d) {
                        return {
                            ...d,
                            filter_id: $('input[name="id_pelanggan"]').val(),
                            filter_nama: $('input[name="nama_pelanggan"]').val(),
                            filter_tarif: $('input[name="tarif[]"]:checked').map(function() {
                                return this.value;
                            }).get(),
                            filter_daya: $('input[name="daya[]"]:checked').map(function() {
                                return this.value;
                            }).get(),
                            tanggal_awal: $('#tanggal_awal').val(),
                            tanggal_akhir: $('#tanggal_akhir').val(),
                            jam_nyala_min: $('input[name="jam_nyala_min"]').val(),
                            jam_nyala_max: $('input[name="jam_nyala_max"]').val()
                        };
                    },
                    dataSrc: function(json) {
                        // Custom info for total transaksi
                        setTimeout(function() {
                            $("#totalTransaksiDT").text(json.recordsTotal);
                        }, 0);
                        return json.data;
                    },
                    error: function(xhr, error, thrown) {
                        console.log('Error:', error);
                        console.log('Response:', xhr.responseText);
                    }
                },
                columns: [
                    { data: '0' }, // IDPEL
                    { data: '1' }, // NAMA
                    { data: '2' }, // TARIP
                    { data: '3' }, // DAYA
                    { data: '4' }, // Jam Nyala
                    { data: '5' }, // PEMKWH
                    { data: '6' }, // RPPENJ
                    { data: '7' }, // TGLBAYAR
                    { data: '8' }  // Total Pembelian
                ],
                columnDefs: [
                    {
                        targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                        className: 'text-center'
                    }
                ],
                pageLength: 10,
                order: [[7, 'asc']],
                language: {
                    processing: "Memuat data...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pelanggan unik (total transaksi: <span id='totalTransaksiDT'></span>)",
                    infoEmpty: "Tidak ada data yang ditampilkan",
                    infoFiltered: "",
                    zeroRecords: "Tidak ada data yang cocok",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            // Refresh table when filters are applied
            $('form').on('submit', function(e) {
                if (!$(e.target).attr('formaction')) {  // Only for search form
                    e.preventDefault();
                    table.ajax.reload();
                }
            });

            // Auto-refresh table when date changes
            $('#tanggal').on('change', function() {
                table.ajax.reload();
            });

            // Update export date when date changes
            $('#tanggal').on('change', function() {
                $('#export_tanggal').val($(this).val());
            });

            // === AUTO RELOAD FILTER ===
            // ID Pelanggan & Nama
            $('input[name="id_pelanggan"], input[name="nama_pelanggan"]').on('input', function() {
                table.ajax.reload();
            });
            // Tarif & Daya (checkbox)
            $('input[name="tarif[]"], input[name="daya[]"]').on('change', function() {
                table.ajax.reload();
            });
            // Jam Nyala (slider & input number)
            $('#jamNyalaInputMin, #jamNyalaInputMax').off('input change');
            $('#jamNyalaInputMin, #jamNyalaInputMax').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    var min = parseInt($('#jamNyalaInputMin').val()) || jamNyalaSlider.noUiSlider.get()[0];
                    var max = parseInt($('#jamNyalaInputMax').val()) || jamNyalaSlider.noUiSlider.get()[1];
                    if (min > max) { var t = min; min = max; max = t; }
                    jamNyalaSlider.noUiSlider.set([min, max]);
                    table.ajax.reload();
                }
            });
            $('#jamNyalaInputMin, #jamNyalaInputMax').on('blur', function() {
                var min = parseInt($('#jamNyalaInputMin').val()) || jamNyalaSlider.noUiSlider.get()[0];
                var max = parseInt($('#jamNyalaInputMax').val()) || jamNyalaSlider.noUiSlider.get()[1];
                if (min > max) { var t = min; min = max; max = t; }
                jamNyalaSlider.noUiSlider.set([min, max]);
                table.ajax.reload();
            });
            // Inisialisasi noUiSlider untuk jam nyala (dual handle)
            var jamNyalaSlider = document.getElementById('jamNyalaSlider');
            var minVal = parseInt($('#jamNyalaInputMin').val()) || 0;
            var maxVal = parseInt($('#jamNyalaInputMax').val()) || 1000;
            if (jamNyalaSlider && !jamNyalaSlider.noUiSlider) {
                noUiSlider.create(jamNyalaSlider, {
                    start: [minVal, maxVal],
                    connect: true,
                    step: 1,
                    range: {
                        'min': 0,
                        'max': 1000
                    },
                    format: {
                        to: function (value) { return Math.round(value); },
                        from: function (value) { return Number(value); }
                    }
                });
            }
            // Sinkronisasi slider ke input
            jamNyalaSlider.noUiSlider.on('update', function(values, handle) {
                var min = Math.round(values[0]);
                var max = Math.round(values[1]);
                $('#jamNyalaInputMin').val(min);
                $('#jamNyalaInputMax').val(max);
                $('#jam_nyala_min').val(min);
                $('#jam_nyala_max').val(max);
            });
            // Sinkronisasi input ke slider (hanya saat Enter atau blur)
            $('#jamNyalaInputMin, #jamNyalaInputMax').off('input change');
            $('#jamNyalaInputMin, #jamNyalaInputMax').on('keydown', function(e) {
                if (e.key === 'Enter') {
                    var min = parseInt($('#jamNyalaInputMin').val()) || jamNyalaSlider.noUiSlider.get()[0];
                    var max = parseInt($('#jamNyalaInputMax').val()) || jamNyalaSlider.noUiSlider.get()[1];
                    if (min > max) { var t = min; min = max; max = t; }
                    jamNyalaSlider.noUiSlider.set([min, max]);
                    table.ajax.reload();
                }
            });
            $('#jamNyalaInputMin, #jamNyalaInputMax').on('blur', function() {
                var min = parseInt($('#jamNyalaInputMin').val()) || jamNyalaSlider.noUiSlider.get()[0];
                var max = parseInt($('#jamNyalaInputMax').val()) || jamNyalaSlider.noUiSlider.get()[1];
                if (min > max) { var t = min; min = max; max = t; }
                jamNyalaSlider.noUiSlider.set([min, max]);
                table.ajax.reload();
            });
            // Event reload DataTables saat slider berubah
            jamNyalaSlider.noUiSlider.on('change', function() {
                table.ajax.reload();
            });

            // Inisialisasi Litepicker untuk filter tanggal
            const picker = new Litepicker({
                element: document.getElementById('filterTanggal'),
                singleMode: false,
                format: 'YYYY-MM-DD',
                autoApply: true,
                lang: 'id',
                setup: (picker) => {
                    picker.on('selected', (start, end) => {
                        $('#tanggal_awal').val(start ? start.format('YYYY-MM-DD') : '');
                        $('#tanggal_akhir').val(end ? end.format('YYYY-MM-DD') : '');
                        // Reload table when date is selected
                        table.ajax.reload();
                    });
                }
            });

            // Set default value jika ada dari GET
            $(document).ready(function() {
                var tglAwal = '<?= isset($_GET['tanggal_awal']) ? htmlspecialchars($_GET['tanggal_awal']) : '' ?>';
                var tglAkhir = '<?= isset($_GET['tanggal_akhir']) ? htmlspecialchars($_GET['tanggal_akhir']) : '' ?>';
                if (tglAwal) $('#tanggal_awal').val(tglAwal);
                if (tglAkhir) $('#tanggal_akhir').val(tglAkhir);
                if (tglAwal && tglAkhir) {
                    $('#filterTanggal').val(tglAwal + ' - ' + tglAkhir);
                    // Trigger initial table load with date filter
                    table.ajax.reload();
                }
                else if (tglAwal) {
                    $('#filterTanggal').val(tglAwal);
                    // Trigger initial table load with date filter
                    table.ajax.reload();
                }
            });
        });
    </script>

    <!-- Copyright -->
    <footer class="bg-light py-3 mt-5">
    <div class="container">
        <p class="text-center mb-0">&copy; 2025 PLN Data Management | All rights reserved.</p>
    </div>
    </footer>
</body>
</html>
