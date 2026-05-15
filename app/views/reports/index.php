<?php require_once '../app/views/layouts/header.php'; ?>

<div class="flex min-h-screen">
    <?php require_once '../app/views/layouts/sidebar.php'; ?>
    
    <main class="flex-1 lg:ml-64 p-8">
        <?php require_once '../app/views/layouts/navbar.php'; ?>

        <div class="space-y-6">
            <?php 
            $flash = getFlash();
            if ($flash): 
                $alertColors = [
                    'success' => 'from-emerald-50 to-emerald-100 border-emerald-200 text-emerald-800',
                    'danger'  => 'from-red-50 to-red-100 border-red-200 text-red-800',
                    'warning' => 'from-amber-50 to-amber-100 border-amber-200 text-amber-800',
                    'info'    => 'from-blue-50 to-blue-100 border-blue-200 text-blue-800'
                ];
                $colorClass = $alertColors[$flash['type']] ?? $alertColors['info'];
            ?>
                <div class="bg-gradient-to-r <?= $colorClass ?> border rounded-2xl p-4 text-sm flex items-center gap-2" data-alert>
                    <span class="material-symbols-outlined text-lg">info</span>
                    <?= $flash['message'] ?>
                </div>
            <?php endif; ?>

            <!-- Export PDF Button -->
            <div class="flex justify-end no-print">
                <a href="<?= BASE_URL ?>report/exportPdf" target="_blank"
                   class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:shadow-lg hover:shadow-red-500/30 transition-all font-medium flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
                    Export PDF
                </a>
            </div>

            <!-- Summary Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="glass-stat rounded-2xl p-5">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Peminjaman</p>
                    <p class="text-3xl font-bold text-gray-900"><?= count($borrowings) ?></p>
                </div>
                <div class="glass-stat rounded-2xl p-5">
                    <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider mb-1">Disetujui</p>
                    <p class="text-3xl font-bold text-emerald-700"><?= count(array_filter($borrowings, fn($b) => $b['status'] === 'approved')) ?></p>
                </div>
                <div class="glass-stat rounded-2xl p-5">
                    <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider mb-1">Pending</p>
                    <p class="text-3xl font-bold text-amber-700"><?= count(array_filter($borrowings, fn($b) => $b['status'] === 'pending')) ?></p>
                </div>
                <div class="glass-stat rounded-2xl p-5">
                    <p class="text-xs font-semibold text-sky-600 uppercase tracking-wider mb-1">Dikembalikan</p>
                    <p class="text-3xl font-bold text-sky-700"><?= count(array_filter($borrowings, fn($b) => $b['status'] === 'returned')) ?></p>
                </div>
            </div>

            <!-- Laporan Peminjaman -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/30">
                    <h5 class="font-semibold text-gray-800">Laporan Peminjaman</h5>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/30">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Pinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Kembali</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/20">
                            <?php $no = 1; foreach ($borrowings as $borrow): ?>
                                <tr class="hover:bg-white/20 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-500"><?= $no++ ?></td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= $borrow['borrow_code'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= $borrow['user_name'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= formatDate($borrow['borrow_date']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= formatDate($borrow['return_date']) ?></td>
                                    <td class="px-6 py-4">
                                        <?php
                                        $statusClass = [
                                            'pending'  => 'bg-amber-100 text-amber-700',
                                            'approved' => 'bg-emerald-100 text-emerald-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                            'returned' => 'bg-sky-100 text-sky-700',
                                        ];
                                        ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $statusClass[$borrow['status']] ?? 'bg-gray-100 text-gray-600' ?>">
                                            <?= ucfirst($borrow['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Laporan Aset -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/30">
                    <h5 class="font-semibold text-gray-800">Laporan Aset</h5>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/30">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Aset</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tersedia</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dipinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/20">
                            <?php $no = 1; foreach ($assets as $asset): ?>
                                <tr class="hover:bg-white/20 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-500"><?= $no++ ?></td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= $asset['code'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= $asset['name'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= $asset['category_name'] ?? '-' ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= $asset['total_quantity'] ?></td>
                                    <td class="px-6 py-4 text-sm text-emerald-700 font-medium"><?= $asset['available_quantity'] ?></td>
                                    <td class="px-6 py-4 text-sm text-amber-700 font-medium"><?= $asset['total_quantity'] - $asset['available_quantity'] ?></td>
                                    <td class="px-6 py-4">
                                        <?php
                                        $condClass = [
                                            'baik'         => 'bg-emerald-100 text-emerald-700',
                                            'rusak ringan' => 'bg-amber-100 text-amber-700',
                                            'rusak berat'  => 'bg-red-100 text-red-700'
                                        ];
                                        ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $condClass[$asset['condition']] ?? 'bg-gray-100 text-gray-600' ?>">
                                            <?= ucfirst($asset['condition']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
@media print {
    aside, nav, .no-print { display: none !important; }
    main { margin-left: 0 !important; }
}
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
