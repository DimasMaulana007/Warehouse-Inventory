<?php
// Pastikan tidak ada output sebelum ini
if (ob_get_level()) ob_end_clean();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get filters with validation
$filterBulan = isset($_GET['bulan']) ? intval($_GET['bulan']) : 0;
$filterTahun = isset($_GET['tahun']) ? intval($_GET['tahun']) : 0;

// Database connection with error handling
$koneksi = mysqli_connect('localhost', 'root', '', 'ipak');
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

try {
    $spreadsheet = new Spreadsheet();
    
    // 1. Get all machines in PRODUKSI INJECT
    $sqlMesin = "SELECT code_mesin, nama_mesin FROM mesin WHERE lokasi = 'PRODUKSI INJECT' ORDER BY nama_mesin ASC";
    $resultMesin = mysqli_query($koneksi, $sqlMesin);
    if (!$resultMesin) {
        throw new Exception("Error getting machines: " . mysqli_error($koneksi));
    }
    
    $allMachines = [];
    while ($row = mysqli_fetch_assoc($resultMesin)) {
        $allMachines[$row['code_mesin']] = $row['nama_mesin'];
    }
    
    // 2. Get all distinct dates that have production data
    $sqlDates = "SELECT DISTINCT tanggal_komponen.tanggal 
                FROM tanggal_komponen
                JOIN proses_komponen ON tanggal_komponen.id_tgl = proses_komponen.tgl
                WHERE 1=1";
    
    if ($filterBulan > 0 && $filterTahun > 0) {
        $sqlDates .= " AND MONTH(tanggal_komponen.tanggal) = $filterBulan 
                      AND YEAR(tanggal_komponen.tanggal) = $filterTahun";
    }
    
    $sqlDates .= " ORDER BY tanggal_komponen.tanggal ASC";
    
    $resultDates = mysqli_query($koneksi, $sqlDates);
    if (!$resultDates) {
        throw new Exception("Error getting dates: " . mysqli_error($koneksi));
    }
    
    $datesWithData = [];
    while ($row = mysqli_fetch_assoc($resultDates)) {
        $datesWithData[] = $row['tanggal'];
    }
    
    // 3. If no date filter, add all dates (even without data) within the month
    if (empty($datesWithData) && $filterBulan > 0 && $filterTahun > 0) {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $filterBulan, $filterTahun);
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $datesWithData[] = date('Y-m-d', mktime(0, 0, 0, $filterBulan, $day, $filterTahun));
        }
    }
    
    // 4. Get production data grouped by date and machine
    $groupedData = [];
    if (!empty($datesWithData)) {
        $dateList = implode("','", array_map(function($date) use ($koneksi) {
            return mysqli_real_escape_string($koneksi, $date);
        }, $datesWithData));
        
        $sqlProduksi = "SELECT 
            proses_komponen.*, 
            komponen.*,
            mesin.nama_mesin, 
            mesin.code_mesin,
            jenis_warna.nama_warna, 
            tanggal_komponen.tanggal 
        FROM proses_komponen
        LEFT JOIN mesin ON proses_komponen.kode_mesin = mesin.code_mesin 
        LEFT JOIN komponen ON komponen.code_komponen = proses_komponen.code_komponen 
        LEFT JOIN tanggal_komponen ON proses_komponen.tgl = tanggal_komponen.id_tgl 
        LEFT JOIN jenis_warna ON komponen.warna = jenis_warna.id_warna 
        WHERE mesin.lokasi = 'PRODUKSI INJECT'
        AND tanggal_komponen.tanggal IN ('$dateList')
        ORDER BY tanggal_komponen.tanggal ASC, mesin.nama_mesin ASC";
        
        $resultProduksi = mysqli_query($koneksi, $sqlProduksi);
        if (!$resultProduksi) {
            throw new Exception("Error getting production data: " . mysqli_error($koneksi));
        }
        
        while ($row = mysqli_fetch_assoc($resultProduksi)) {
            $tanggal = $row['tanggal'] ?? '0000-00-00';
            $codeMesin = $row['code_mesin'] ?? '';
            $namaMesin = $row['nama_mesin'] ?? 'Unknown';
            $namaKomponen = $row['nama_komponen'] ?? 'Unknown';
            
            if (!isset($groupedData[$tanggal])) {
                $groupedData[$tanggal] = [];
            }
            
            if (!isset($groupedData[$tanggal][$codeMesin])) {
                $groupedData[$tanggal][$codeMesin] = [
                    'nama_mesin' => $namaMesin,
                    'komponen' => []
                ];
            }
            
            if (!empty($row['code_komponen'])) {
                if (!isset($groupedData[$tanggal][$codeMesin]['komponen'][$namaKomponen])) {
                    $groupedData[$tanggal][$codeMesin]['komponen'][$namaKomponen] = [
                        'nama_komponen' => $namaKomponen,
                        'cavity' => $row['cavity'] ?? 0,
                        'cycle_time' => $row['cycle_time'] ?? 0,
                        'berat_komponen' => $row['berat_komponen'] ?? 0,
                        'shifts' => []
                    ];
                }
                
                $groupedData[$tanggal][$codeMesin]['komponen'][$namaKomponen]['shifts'][] = [
                    'shift' => $row['shift'] ?? '-',
                    'jam_mulai' => isset($row['jam_mulai']) ? substr(str_replace('.', ':', $row['jam_mulai']), 0, 5) : '-',
                    'jam_selesai' => isset($row['jam_selesai']) ? substr(str_replace('.', ':', $row['jam_selesai']), 0, 5) : '-',
                    'produksi_ok' => $row['produksi_ok'] ?? 0,
                    'produksi_ng' => $row['produksi_ng'] ?? 0,
                    'nama_operator' => $row['nama_operator'] ?? '-',
                    'keterangan' => $row['keterangan'] ?? '-'
                ];
            }
        }
    }

    // Common styles
    $headerStyle = [
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'color' => ['argb' => 'FFD3D3D3'],
        ],
    ];

    $borderStyle = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ];

    $centerStyle = [
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
    ];

    $sheetIndex = 0;
    
    // Create sheets for each date
    foreach ($datesWithData as $tanggal) {
        $sheet = ($sheetIndex == 0) ? $spreadsheet->getActiveSheet() : $spreadsheet->createSheet($sheetIndex);
        
        // Format sheet title (max 31 chars)
        $sheetTitle = date('d-m-Y', strtotime($tanggal));
        $sheet->setTitle(substr($sheetTitle, 0, 31));
        
        // Set header
        $sheet->setCellValue('B1', 'Tanggal: ' . date('d F Y', strtotime($tanggal)));
        $sheet->mergeCells('B1:T1');
        $sheet->getStyle('B1')->getFont()->setBold(true);
    
        // Column headers
        $headers = [
            'NO', 'Nama Mesin', 'Nama Komponen', 'Cav', 'Cycle Time', 'Berat Produk', 'Target Per shift',
            'Shift', 'Start', 'End', 'Total', 'OK', 'NG', 'Total OK', 'Total NG', 
            'Percent NG', 'Pencapaian Target', 'Nama Operator', 'Problem/Keterangan'
        ];
        
        $sheet->fromArray($headers, null, 'B2');
        $sheet->getStyle('B2:T2')->applyFromArray($headerStyle);
        
        $row = 3;
        $no = 1;
        
        // Loop through ALL machines for this date
        foreach ($allMachines as $codeMesin => $namaMesin) {
            $hasData = isset($groupedData[$tanggal][$codeMesin]);
            
            if ($hasData) {
                $machineData = $groupedData[$tanggal][$codeMesin];
                $komponens = $machineData['komponen'];
                
                foreach ($komponens as $namaKomponen => $data) {
                    $startRow = $row;
                    $totalOK = 0;
                    $totalNG = 0;
                    
                    foreach ($data['shifts'] as $shift) {
                        // Calculate time difference in minutes
                        $menit = 0;
                        if ($shift['jam_mulai'] != '-' && $shift['jam_selesai'] != '-') {
                            try {
                                $mulai = DateTime::createFromFormat('H:i', $shift['jam_mulai']);
                                $selesai = DateTime::createFromFormat('H:i', $shift['jam_selesai']);
                                
                                if ($selesai < $mulai) {
                                    $selesai->modify('+1 day');
                                }
                                
                                $interval = $mulai->diff($selesai);
                                $menit = ($interval->h * 60) + $interval->i;
                            } catch (Exception $e) {
                                $menit = 0;
                            }
                        }
                        
                        // Calculate target
                        $target = 0;
                        if ($data['cavity'] > 0 && $data['cycle_time'] > 0) {
                            $target = round((3600 / ($data['cavity'] * $data['cycle_time'])) * 7);
                        }
                        
                        // Calculate achievement percentage
                        $achievement = 0;
                        if ($target > 0) {
                            $achievement = round(($shift['produksi_ok'] / $target) * 100);
                        }
                        
                        // Write shift data
                        $sheet->setCellValue('B' . $row, $no++);
                        $sheet->setCellValue('I' . $row, $shift['shift']);
                        $sheet->setCellValue('J' . $row, $shift['jam_mulai']);
                        $sheet->setCellValue('K' . $row, $shift['jam_selesai']);
                        $sheet->setCellValue('L' . $row, $menit);
                        $sheet->setCellValue('M' . $row, $shift['produksi_ok']);
                        $sheet->setCellValue('N' . $row, $shift['produksi_ng']);
                        $sheet->setCellValue('S' . $row, $shift['nama_operator']);
                        $sheet->setCellValue('T' . $row, $shift['keterangan']);
                        $sheet->setCellValue('R' . $row, $achievement . '%');
                        
                        $totalOK += $shift['produksi_ok'];
                        $totalNG += $shift['produksi_ng'];
                        
                        $row++;
                    }
                    
                    // Calculate NG percentage
                    $ngPercentage = 0;
                    $totalProduction = $totalOK + $totalNG;
                    if ($totalProduction > 0) {
                        $ngPercentage = round(($totalNG / $totalProduction) * 100);
                    }
                    $endRow = $row - 1;
                    // Set totals
                    $sheet->mergeCells("C{$startRow}:C{$endRow}")->setCellValue("C{$startRow}", $namaMesin);
                    $sheet->mergeCells("D{$startRow}:D{$endRow}")->setCellValue("D{$startRow}", $namaKomponen);
                    $sheet->mergeCells("E{$startRow}:E{$endRow}")->setCellValue("E{$startRow}", $data['cavity']);
                    $sheet->mergeCells("F{$startRow}:F{$endRow}")->setCellValue("F{$startRow}", $data['cycle_time']);
                    $sheet->mergeCells("G{$startRow}:G{$endRow}")->setCellValue("G{$startRow}", $data['berat_komponen']);
                    $sheet->mergeCells("H{$startRow}:H{$endRow}")->setCellValue("H{$startRow}", $target);
                    $sheet->mergeCells("O{$startRow}:O{$endRow}")->setCellValue("O{$startRow}", $totalOK);
                    $sheet->mergeCells("P{$startRow}:P{$endRow}")->setCellValue("P{$startRow}", $totalNG);
                    $sheet->mergeCells("Q{$startRow}:Q{$endRow}")->setCellValue("Q{$startRow}", $ngPercentage . '%');
                    
                    // Apply styles
                    $sheet->getStyle("B{$startRow}:T" . ($row-1))->applyFromArray($borderStyle);
                    $sheet->getStyle("B{$startRow}:T" . ($row-1))->applyFromArray($centerStyle);
                }
            } else {
                // Show machine with no data
                $sheet->setCellValue('B' . $row, $no++);
                $sheet->setCellValue('C' . $row, $namaMesin);
                $sheet->setCellValue('D' . $row, 'Tidak ada data produksi');
                $sheet->mergeCells('D' . $row . ':T' . $row);
                
                $sheet->getStyle("B{$row}:T{$row}")->applyFromArray($borderStyle);
                $sheet->getStyle("B{$row}:T{$row}")->applyFromArray($centerStyle);
                $row++;
            }
        }
        
        // Auto-size columns
        foreach (range('B', 'T') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        $sheetIndex++;
    }

    // Clean output and send Excel file
    ob_end_clean();
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Laporan_Injection_'.date('Y-m').'.xlsx"');
    header('Cache-Control: max-age=0');
    header('Pragma: no-cache');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

} catch (Exception $e) {
    ob_end_clean();
    die("Error: " . $e->getMessage());
}
?>