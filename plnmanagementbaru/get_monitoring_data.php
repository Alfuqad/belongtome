<?php
require 'backend/db.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Parameters from DataTables
$draw = isset($_POST['draw']) ? $_POST['draw'] : 1;
$start = isset($_POST['start']) ? $_POST['start'] : 0;
$length = isset($_POST['length']) ? $_POST['length'] : 10;
$search = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
$order_column = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
$order_dir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';

// Filter parameters
$filter_id = isset($_POST['filter_id']) ? $_POST['filter_id'] : '';
$filter_nama = isset($_POST['filter_nama']) ? $_POST['filter_nama'] : '';
$filter_status = isset($_POST['filter_status']) ? $_POST['filter_status'] : '';
$filter_tarif = isset($_POST['filter_tarif']) ? $_POST['filter_tarif'] : [];
$filter_daya = isset($_POST['filter_daya']) ? $_POST['filter_daya'] : [];
$tanggal_awal = isset($_POST['tanggal_awal']) ? $_POST['tanggal_awal'] : '';
$tanggal_akhir = isset($_POST['tanggal_akhir']) ? $_POST['tanggal_akhir'] : '';
$jam_nyala_min = isset($_POST['jam_nyala_min']) && $_POST['jam_nyala_min'] !== '' ? floatval($_POST['jam_nyala_min']) : 20;
$jam_nyala_max = isset($_POST['jam_nyala_max']) && $_POST['jam_nyala_max'] !== '' ? floatval($_POST['jam_nyala_max']) : 160;

// Debug received parameters
error_log("Received parameters: " . print_r($_POST, true));

// If no date range is provided, use current date
if (empty($tanggal_awal)) {
    $tanggal_awal = date('Y-m-d');
    $tanggal_akhir = date('Y-m-d');
}

// Extract year and month from the start date
$date_parts = explode('-', $tanggal_awal);
$selected_year = $date_parts[0];
$month_number = $date_parts[1];

// Convert month number to month name
$month_names = [
    '01' => 'januari',
    '02' => 'februari',
    '03' => 'maret',
    '04' => 'april',
    '05' => 'mei',
    '06' => 'juni',
    '07' => 'juli',
    '08' => 'agustus',
    '09' => 'september',
    '10' => 'oktober',
    '11' => 'november',
    '12' => 'desember'
];

$selected_month = $month_names[$month_number];

error_log("Selected year: " . $selected_year);
error_log("Selected month: " . $selected_month);

// Database selection
$database_name = "pln_db" . $selected_year;
if (!in_array($selected_year, ['2024', '2025'])) {
    $database_name = 'pln_db2025';
}

// Table selection based on month and year
$table_name = "lpb_" . $selected_month . $selected_year;

error_log("Database name: " . $database_name);
error_log("Table name: " . $table_name);

// Try to select database
if (!mysqli_select_db($conn, $database_name)) {
    $response = array(
        "draw" => intval($draw),
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => array(),
        "error" => "Database tidak ditemukan: " . $database_name
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Check if table exists, if not, use default table
$table_check = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");
if (mysqli_num_rows($table_check) == 0) {
    // If table doesn't exist, use default table (e.g., lpb_desember2025)
    $table_name = "lpb_desember2025";
    // Check if default table exists
    $default_check = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");
    if (mysqli_num_rows($default_check) == 0) {
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => array(),
            "error" => "Tabel yang diperlukan tidak ditemukan. Silakan hubungi administrator."
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

// Column names for ordering
$columns = array(
    0 => 'IDPEL',
    1 => 'NAMA',
    2 => 'TARIP',
    3 => 'DAYA',
    4 => 'KDSWITCHING',
    5 => 'TGLBAYAR',
    6 => 'PEMKWH',
    7 => 'RPPENJ'
);

// Base query
$where = "WHERE 1=1";

// Apply date range filter only if dates are explicitly selected
if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
    // Gunakan format yang sama persis dengan database
    $where .= " AND TGLBAYAR BETWEEN STR_TO_DATE('" . mysqli_real_escape_string($conn, $tanggal_awal) . "', '%Y-%m-%d') AND STR_TO_DATE('" . mysqli_real_escape_string($conn, $tanggal_akhir) . "', '%Y-%m-%d')";
}

error_log("Date filter condition: " . $where);

// Apply other filters only if they are explicitly set
if (!empty($filter_id)) {
    $where .= " AND IDPEL LIKE '%" . mysqli_real_escape_string($conn, $filter_id) . "%'";
}
if (!empty($filter_nama)) {
    $where .= " AND NAMA LIKE '%" . mysqli_real_escape_string($conn, $filter_nama) . "%'";
}
if ($filter_status === 'Nyala') {
    $where .= " AND KDSWITCHING LIKE '%CA01'";
} elseif ($filter_status === 'Mati') {
    $where .= " AND KDSWITCHING NOT LIKE '%CA01'";
}
if (!empty($filter_tarif)) {
    $tarif_in = "'" . implode("','", array_map(function ($item) use ($conn) {
        return mysqli_real_escape_string($conn, $item);
    }, $filter_tarif)) . "'";
    $where .= " AND TARIP IN ($tarif_in)";
}
if (!empty($filter_daya)) {
    $daya_in = "'" . implode("','", array_map(function ($item) use ($conn) {
        return mysqli_real_escape_string($conn, $item);
    }, $filter_daya)) . "'";
    $where .= " AND DAYA IN ($daya_in)";
}

// Filter jam nyala range only if explicitly set
if ($jam_nyala_min !== 20 || $jam_nyala_max !== 160) {
    $where .= " AND (CASE WHEN DAYA > 0 THEN PEMKWH/(DAYA/1000) ELSE 0 END) >= $jam_nyala_min AND (CASE WHEN DAYA > 0 THEN PEMKWH/(DAYA/1000) ELSE 0 END) <= $jam_nyala_max";
}

// Apply search only if search term is provided
if (!empty($search)) {
    $where .= " AND (IDPEL LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR 
                     NAMA LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR 
                     TARIP LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR 
                     DAYA LIKE '%" . mysqli_real_escape_string($conn, $search) . "%')";
}

// Debug query
error_log("Final WHERE clause: " . $where);

// Get the exact count from database first
$exact_count_query = "SELECT COUNT(*) as exact_count FROM $table_name";
$exact_count_result = mysqli_query($conn, $exact_count_query);
if (!$exact_count_result) {
    error_log("Error in exact count query: " . mysqli_error($conn));
}
$exact_count = mysqli_fetch_assoc($exact_count_result)['exact_count'];
error_log("Exact count from database: " . $exact_count);

// Count filtered records - gunakan query yang sama persis dengan yang di database
$filtered_count_query = "SELECT COUNT(*) as filtered_count FROM $table_name $where";
$filtered_count_result = mysqli_query($conn, $filtered_count_query);
if (!$filtered_count_result) {
    error_log("Error in filtered count query: " . mysqli_error($conn));
}
$filtered_count = mysqli_fetch_assoc($filtered_count_result)['filtered_count'];
error_log("Filtered count: " . $filtered_count);

// Get statistics for filtered data
$sql_stats = "SELECT 
    COUNT(*) as total_pelanggan,
    SUM(CASE WHEN KDSWITCHING LIKE '%CA01' THEN 1 ELSE 0 END) as daya_normal,
    SUM(CASE WHEN KDSWITCHING NOT LIKE '%CA01' THEN 1 ELSE 0 END) as daya_tidak_normal
FROM $table_name $where";

$stats_result = mysqli_query($conn, $sql_stats);
if (!$stats_result) {
    error_log("Error in stats query: " . mysqli_error($conn));
    $error = "Error in stats query: " . mysqli_error($conn) . "\nQuery: " . $sql_stats;
    $response = array(
        "draw" => intval($draw),
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => array(),
        "error" => $error
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$stats = mysqli_fetch_assoc($stats_result);
error_log("Stats: " . print_r($stats, true));

// Ambil data hanya dari transaksi dalam range tanggal (filtered)
$sql = "WITH 
filtered AS (
    SELECT * FROM $table_name $where
),
agregat AS (
    SELECT 
        IDPEL,
        COUNT(*) as total_pembelian,
        SUM(PEMKWH) as total_pemkwh,
        SUM(RPPENJ) as total_rppenj,
        MIN(TGLBAYAR) as tgl_bayar_awal,
        MAX(TGLBAYAR) as tgl_bayar_akhir
    FROM filtered
    GROUP BY IDPEL
),
terakhir AS (
    SELECT f.*
    FROM filtered f
    INNER JOIN (
        SELECT IDPEL, MAX(TGLBAYAR) as max_tgl
        FROM filtered
        GROUP BY IDPEL
    ) t ON f.IDPEL = t.IDPEL AND f.TGLBAYAR = t.max_tgl
)
SELECT 
    a.IDPEL,
    t.NAMA,
    t.TARIP,
    t.DAYA,
    t.KDSWITCHING,
    CONCAT(DATE_FORMAT(a.tgl_bayar_awal, '%d-%m-%Y'), ' s/d ', DATE_FORMAT(a.tgl_bayar_akhir, '%d-%m-%Y')) as TGLBAYAR,
    t.PEMKWH,
    t.RPPENJ,
    a.total_pembelian,
    a.total_pemkwh,
    a.total_rppenj
FROM agregat a
JOIN terakhir t ON a.IDPEL = t.IDPEL
ORDER BY a.IDPEL
LIMIT $start, $length";

error_log("Data query: " . $sql);

$result = mysqli_query($conn, $sql);
if (!$result) {
    error_log("Error in data query: " . mysqli_error($conn));
    $error = "Error in data query: " . mysqli_error($conn) . "\nQuery: " . $sql;
    $response = array(
        "draw" => intval($draw),
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => array(),
        "error" => $error
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Prepare data array
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    // Calculate jam nyala using the formula: pemkwh / (daya/1000)
    $daya_kw = floatval($row['DAYA']) / 1000; // Convert daya to kW
    $pemkwh = floatval($row['PEMKWH']);
    $jam_nyala = $daya_kw > 0 ? round($pemkwh / $daya_kw, 2) : 0;
    $jam_nyala = $jam_nyala . " jam";

    // Format numbers
    $total_pemkwh = number_format($row['total_pemkwh'], 1, ',', '.');
    $total_rppenj = number_format($row['total_rppenj'], 0, ',', '.');
    $total_pembelian = number_format($row['total_pembelian'], 0, ',', '.');
    $pemkwh = number_format($row['PEMKWH'], 1, ',', '.');

    $data[] = array(
        $row['IDPEL'],
        $row['NAMA'],
        $row['TARIP'],
        $row['DAYA'],
        $jam_nyala,
        $pemkwh,
        $row['RPPENJ'],
        $row['TGLBAYAR'],
        $total_pembelian,
        $total_pemkwh,
        $total_rppenj
    );
}

// Prepare response
$response = array(
    "draw" => intval($draw),
    "recordsTotal" => intval($exact_count),
    "recordsFiltered" => intval($filtered_count),
    "data" => $data,
    "stats" => array(
        "total_pelanggan" => intval($stats['total_pelanggan']),
        "daya_normal" => intval($stats['daya_normal']),
        "daya_tidak_normal" => intval($stats['daya_tidak_normal'])
    )
);

// Debug final response
error_log("Response: " . json_encode($response));

// Set proper JSON header
header('Content-Type: application/json');

// Output JSON response
echo json_encode($response);
?>