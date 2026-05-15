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

            <!-- Action Button -->
            <?php if (getUserRole() === 'user'): ?>
            <div class="flex justify-end">
                <a href="<?= BASE_URL ?>borrow/create" class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all font-medium flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">add</span>
                    Ajukan Peminjaman
                </a>
            </div>
            <?php endif; ?>

            <!-- Table Card -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/30">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                                <?php if (getUserRole() !== 'user'): ?>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                                <?php endif; ?>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Pinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Kembali</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Keperluan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/20">
                            <?php foreach ($borrowings as $borrow): ?>
                                <tr class="hover:bg-white/20 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= $borrow['borrow_code'] ?></td>
                                    <?php if (getUserRole() !== 'user'): ?>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-medium text-gray-900"><?= $borrow['user_name'] ?></p>
                                            <p class="text-xs text-gray-500"><?= $borrow['nim_nip'] ?></p>
                                        </td>
                                    <?php endif; ?>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= formatDate($borrow['borrow_date']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= formatDate($borrow['return_date']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= substr($borrow['purpose'], 0, 50) ?>...</td>
                                    <td class="px-6 py-4">
                                        <?php
                                        $statusClass = [
                                            'pending'   => 'bg-amber-100 text-amber-700',
                                            'approved'  => 'bg-emerald-100 text-emerald-700',
                                            'rejected'  => 'bg-red-100 text-red-700',
                                            'returned'  => 'bg-sky-100 text-sky-700',
                                            'cancelled' => 'bg-gray-100 text-gray-600',
                                            'pending_return' => 'bg-purple-100 text-purple-700'
                                        ];
                                        $statusLabel = [
                                            'pending'   => 'Menunggu Verifikasi Peminjaman',
                                            'approved'  => 'Approved',
                                            'rejected'  => 'Rejected',
                                            'returned'  => 'Returned',
                                            'cancelled' => 'Cancelled',
                                            'pending_return' => 'Menunggu Verifikasi Pengembalian'
                                        ];
                                        ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $statusClass[$borrow['status']] ?? 'bg-gray-100 text-gray-600' ?>">
                                            <?= $statusLabel[$borrow['status']] ?? ucfirst($borrow['status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="<?= BASE_URL ?>borrow/detail/<?= $borrow['id'] ?>" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/30 text-gray-600 hover:text-sky-600 transition-colors">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </a>
                                            <?php if ($borrow['status'] === 'approved' && getUserRole() === 'user'): ?>
                                                <a href="<?= BASE_URL ?>return/create/<?= $borrow['id'] ?>" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500 text-white text-xs font-medium rounded-lg hover:bg-emerald-600 transition-colors">
                                                    <span class="material-symbols-outlined text-sm">undo</span>
                                                    Kembalikan
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($borrow['status'] === 'pending' && getUserRole() === 'user'): ?>
                                                <a href="<?= BASE_URL ?>borrow/cancel/<?= $borrow['id'] ?>" 
                                                   class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/30 text-gray-600 hover:text-red-600 transition-colors"
                                                   onclick="return confirm('Batalkan peminjaman ini?')">
                                                    <span class="material-symbols-outlined text-lg">cancel</span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($borrowings)): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        <span class="material-symbols-outlined text-5xl block mb-2 text-gray-300">inbox</span>
                                        Belum ada data peminjaman
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
