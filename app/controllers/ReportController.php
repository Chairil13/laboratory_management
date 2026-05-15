<?php

class ReportController extends Controller {
    private $borrowingModel;
    private $assetModel;

    public function __construct() {
        $this->requireLogin();
        $this->checkRole(['kepala_lab', 'admin']);
        $this->borrowingModel = $this->model('Borrowing');
        $this->assetModel = $this->model('Asset');
    }

    public function index() {
        $data = [
            'title' => 'Laporan',
            'borrowings' => $this->borrowingModel->getAllWithDetails(),
            'assets' => $this->assetModel->getAllWithCategory()
        ];

        $this->view('reports/index', $data);
    }

    public function exportPdf() {
        $borrowings = $this->borrowingModel->getAllWithDetails();
        $assets = $this->assetModel->getAllWithCategory();
        
        // Generate HTML content for PDF
        $html = $this->generatePdfHtml($borrowings, $assets);
        
        // Output HTML directly - browser will handle PDF conversion via print dialog
        echo $html;
        exit;
    }

    private function generatePdfHtml($borrowings, $assets) {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Laporan Laboratorium</title>
            <style>
                @media print {
                    @page { margin: 1cm; size: A4; }
                    body { margin: 0; }
                }
                body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; background: white; }
                h1 { text-align: center; color: #333; font-size: 18px; margin-bottom: 5px; }
                h2 { font-size: 14px; color: #555; margin-top: 20px; margin-bottom: 10px; border-bottom: 2px solid #333; padding-bottom: 5px; }
                .header { text-align: center; margin-bottom: 30px; }
                .header p { margin: 2px 0; color: #666; font-size: 11px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                th { background-color: #f0f0f0; padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 11px; font-weight: bold; }
                td { padding: 6px 8px; border: 1px solid #ddd; font-size: 11px; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .badge { padding: 3px 8px; border-radius: 3px; font-size: 10px; font-weight: bold; display: inline-block; }
                .badge-pending { background: #fef3c7; color: #92400e; }
                .badge-approved { background: #d1fae5; color: #065f46; }
                .badge-rejected { background: #fee2e2; color: #991b1b; }
                .badge-returned { background: #dbeafe; color: #1e40af; }
                .badge-baik { background: #d1fae5; color: #065f46; }
                .badge-rusak-ringan { background: #fef3c7; color: #92400e; }
                .badge-rusak-berat { background: #fee2e2; color: #991b1b; }
                .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #666; }
                .no-print { display: none; }
                .print-btn { 
                    position: fixed; 
                    top: 20px; 
                    right: 20px; 
                    padding: 12px 24px; 
                    background: #10b981; 
                    color: white; 
                    border: none; 
                    border-radius: 8px; 
                    cursor: pointer; 
                    font-size: 14px;
                    font-weight: 600;
                    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                    z-index: 1000;
                }
                .print-btn:hover { background: #059669; }
                @media print {
                    .print-btn { display: none; }
                }
            </style>
        </head>
        <body>
            <button class="print-btn" onclick="window.print()">🖨️ Cetak / Save as PDF</button>

            <div class="header">
                <h1>LAPORAN SISTEM MANAJEMEN LABORATORIUM</h1>
                <p>Departemen Teknik Elektro</p>
                <p>Tanggal Cetak: <?= date('d F Y, H:i') ?> WIB</p>
            </div>

            <h2>Ringkasan Statistik</h2>
            <table style="width: 100%; margin-bottom: 20px;">
                <tr>
                    <td style="text-align: center; background: #f9fafb; padding: 15px;">
                        <div style="font-size: 24px; font-weight: bold; color: #333; margin-bottom: 5px;"><?= count($borrowings) ?></div>
                        <div style="font-size: 11px; color: #666;">Total Peminjaman</div>
                    </td>
                    <td style="text-align: center; background: #f0fdf4; padding: 15px;">
                        <div style="font-size: 24px; font-weight: bold; color: #059669; margin-bottom: 5px;"><?= count(array_filter($borrowings, fn($b) => $b['status'] === 'approved')) ?></div>
                        <div style="font-size: 11px; color: #065f46;">Disetujui</div>
                    </td>
                    <td style="text-align: center; background: #fffbeb; padding: 15px;">
                        <div style="font-size: 24px; font-weight: bold; color: #d97706; margin-bottom: 5px;"><?= count(array_filter($borrowings, fn($b) => $b['status'] === 'pending')) ?></div>
                        <div style="font-size: 11px; color: #92400e;">Pending</div>
                    </td>
                    <td style="text-align: center; background: #eff6ff; padding: 15px;">
                        <div style="font-size: 24px; font-weight: bold; color: #2563eb; margin-bottom: 5px;"><?= count(array_filter($borrowings, fn($b) => $b['status'] === 'returned')) ?></div>
                        <div style="font-size: 11px; color: #1e40af;">Dikembalikan</div>
                    </td>
                </tr>
            </table>

            <h2>Laporan Peminjaman</h2>
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">Kode</th>
                        <th style="width: 20%;">Peminjam</th>
                        <th style="width: 12%;">Tgl Pinjam</th>
                        <th style="width: 12%;">Tgl Kembali</th>
                        <th style="width: 12%;">Status</th>
                        <th style="width: 24%;">Keperluan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($borrowings)): ?>
                        <tr><td colspan="7" style="text-align: center; padding: 20px; color: #999;">Tidak ada data peminjaman</td></tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($borrowings as $borrow): ?>
                            <tr>
                                <td style="text-align: center;"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($borrow['borrow_code']) ?></td>
                                <td><?= htmlspecialchars($borrow['user_name']) ?></td>
                                <td><?= date('d/m/Y', strtotime($borrow['borrow_date'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($borrow['return_date'])) ?></td>
                                <td>
                                    <?php
                                    $statusClass = [
                                        'pending' => 'badge-pending',
                                        'approved' => 'badge-approved',
                                        'rejected' => 'badge-rejected',
                                        'returned' => 'badge-returned'
                                    ];
                                    ?>
                                    <span class="badge <?= $statusClass[$borrow['status']] ?? '' ?>">
                                        <?= ucfirst($borrow['status']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars(substr($borrow['purpose'], 0, 50)) ?><?= strlen($borrow['purpose']) > 50 ? '...' : '' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <h2>Laporan Aset</h2>
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 12%;">Kode</th>
                        <th style="width: 28%;">Nama Aset</th>
                        <th style="width: 15%;">Kategori</th>
                        <th style="width: 8%;">Total</th>
                        <th style="width: 8%;">Tersedia</th>
                        <th style="width: 8%;">Dipinjam</th>
                        <th style="width: 16%;">Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($assets)): ?>
                        <tr><td colspan="8" style="text-align: center; padding: 20px; color: #999;">Tidak ada data aset</td></tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($assets as $asset): ?>
                            <tr>
                                <td style="text-align: center;"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($asset['code']) ?></td>
                                <td><?= htmlspecialchars($asset['name']) ?></td>
                                <td><?= htmlspecialchars($asset['category_name'] ?? '-') ?></td>
                                <td style="text-align: center;"><?= $asset['total_quantity'] ?></td>
                                <td style="text-align: center; color: #059669; font-weight: bold;"><?= $asset['available_quantity'] ?></td>
                                <td style="text-align: center; color: #d97706; font-weight: bold;"><?= $asset['total_quantity'] - $asset['available_quantity'] ?></td>
                                <td>
                                    <?php
                                    $condClass = [
                                        'baik' => 'badge-baik',
                                        'rusak ringan' => 'badge-rusak-ringan',
                                        'rusak berat' => 'badge-rusak-berat'
                                    ];
                                    ?>
                                    <span class="badge <?= $condClass[$asset['condition']] ?? '' ?>">
                                        <?= ucfirst($asset['condition']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="footer">
                <p><strong>Dicetak oleh:</strong> <?= htmlspecialchars(getUserName()) ?> (<?= ucfirst(str_replace('_', ' ', getUserRole())) ?>)</p>
                <p>Sistem Manajemen Laboratorium - Departemen Teknik Elektro</p>
            </div>

            <script>
                // Auto-open print dialog after page loads
                window.onload = function() {
                    // Small delay to ensure page is fully rendered
                    setTimeout(function() {
                        // Uncomment below to auto-open print dialog
                        // window.print();
                    }, 500);
                };
            </script>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }

    private function generatePdfFromHtml($html) {
        // This method is no longer needed with the new approach
        // Keeping it for backward compatibility
        echo $html;
    }
}

