<?php require_once '../app/views/layouts/header.php'; ?>

<div class="flex min-h-screen">
    <?php require_once '../app/views/layouts/sidebar.php'; ?>
    
    <main class="flex-1 lg:ml-64 p-8">
        <?php require_once '../app/views/layouts/navbar.php'; ?>

        <div class="space-y-6">

            <!-- Info Peminjaman -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/30">
                    <h5 class="font-semibold text-gray-800">Informasi Peminjaman</h5>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <span class="text-sm font-medium text-gray-500 w-36 shrink-0">Kode</span>
                            <span class="text-sm text-gray-900 font-semibold"><?= $borrowing['borrow_code'] ?></span>
                        </div>
                        <div class="flex gap-3">
                            <span class="text-sm font-medium text-gray-500 w-36 shrink-0">Tanggal Pinjam</span>
                            <span class="text-sm text-gray-900"><?= formatDate($borrowing['borrow_date']) ?></span>
                        </div>
                        <div class="flex gap-3">
                            <span class="text-sm font-medium text-gray-500 w-36 shrink-0">Tanggal Kembali</span>
                            <span class="text-sm text-gray-900"><?= formatDate($borrowing['return_date']) ?></span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <span class="text-sm font-medium text-gray-500 w-36 shrink-0">Status</span>
                            <?php
                            $statusClass = [
                                'pending'  => 'bg-amber-100 text-amber-700',
                                'approved' => 'bg-emerald-100 text-emerald-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                'returned' => 'bg-sky-100 text-sky-700'
                            ];
                            ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $statusClass[$borrowing['status']] ?? 'bg-gray-100 text-gray-600' ?>">
                                <?= ucfirst($borrowing['status']) ?>
                            </span>
                        </div>
                        <div class="flex gap-3">
                            <span class="text-sm font-medium text-gray-500 w-36 shrink-0">Keperluan</span>
                            <span class="text-sm text-gray-900"><?= $borrowing['purpose'] ?></span>
                        </div>
                        <?php if ($borrowing['notes']): ?>
                        <div class="flex gap-3">
                            <span class="text-sm font-medium text-gray-500 w-36 shrink-0">Catatan</span>
                            <span class="text-sm text-gray-900"><?= $borrowing['notes'] ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Daftar Aset -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/30">
                    <h5 class="font-semibold text-gray-800">Daftar Aset</h5>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/30">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode Aset</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Aset</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/20">
                            <?php foreach ($details as $detail): ?>
                                <tr class="hover:bg-white/20 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= $detail['asset_code'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= $detail['asset_name'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= $detail['quantity'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Back Button -->
            <div>
                <a href="<?= BASE_URL ?>borrow"
                   class="inline-flex items-center gap-2 px-6 py-3 glass-card rounded-xl hover-lift text-gray-700 font-medium">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Kembali
                </a>
            </div>
        </div>
    </main>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
