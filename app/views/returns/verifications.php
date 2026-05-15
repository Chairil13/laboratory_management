<?php require_once '../app/views/layouts/header.php'; ?>

<div class="flex min-h-screen">
    <?php require_once '../app/views/layouts/sidebar.php'; ?>
    
    <main class="flex-1 lg:ml-64 p-8">
        <?php require_once '../app/views/layouts/navbar.php'; ?>

        <div class="space-y-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Verifikasi Pengembalian</h1>
                    <p class="text-gray-600 mt-1">Kelola dan verifikasi pengembalian aset dari mahasiswa</p>
                </div>
            </div>

            <!-- Pending Returns -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/30 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-amber-600 text-2xl">pending_actions</span>
                        <h5 class="font-semibold text-gray-800">Menunggu Verifikasi</h5>
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">
                            <?= count($pending_returns) ?> Pending
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <?php if (empty($pending_returns)): ?>
                        <div class="text-center py-12">
                            <span class="material-symbols-outlined text-gray-300 text-6xl">check_circle</span>
                            <p class="text-gray-500 mt-4">Tidak ada pengembalian yang menunggu verifikasi</p>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Kode Pinjam</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Mahasiswa</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">NIM</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal Kembali</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Kondisi</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Catatan</th>
                                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pending_returns as $return): ?>
                                        <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <span class="font-semibold text-gray-800"><?= $return['borrow_code'] ?></span>
                                            </td>
                                            <td class="py-4 px-4 text-gray-700"><?= $return['user_name'] ?></td>
                                            <td class="py-4 px-4 text-gray-600"><?= $return['nim_nip'] ?></td>
                                            <td class="py-4 px-4 text-gray-700"><?= formatDate($return['return_date']) ?></td>
                                            <td class="py-4 px-4">
                                                <?php
                                                $conditionClass = [
                                                    'baik' => 'bg-emerald-100 text-emerald-700',
                                                    'rusak ringan' => 'bg-amber-100 text-amber-700',
                                                    'rusak berat' => 'bg-red-100 text-red-700'
                                                ];
                                                ?>
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $conditionClass[$return['condition']] ?>">
                                                    <?= ucfirst($return['condition']) ?>
                                                </span>
                                            </td>
                                            <td class="py-4 px-4 text-gray-600 text-sm max-w-xs truncate">
                                                <?= $return['notes'] ?: '-' ?>
                                            </td>
                                            <td class="py-4 px-4">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="<?= BASE_URL ?>return/approve/<?= $return['id'] ?>" 
                                                       onclick="return confirm('Setujui pengembalian ini?')"
                                                       class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-lg hover:shadow-lg hover:shadow-emerald-500/30 transition-all text-sm font-medium flex items-center gap-1">
                                                        <span class="material-symbols-outlined text-base">check_circle</span>
                                                        Setuju
                                                    </a>
                                                    <button onclick="openRejectModal(<?= $return['id'] ?>, '<?= $return['borrow_code'] ?>')"
                                                            class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:shadow-lg hover:shadow-red-500/30 transition-all text-sm font-medium flex items-center gap-1">
                                                        <span class="material-symbols-outlined text-base">cancel</span>
                                                        Tolak
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Return History -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/30 flex items-center gap-3">
                    <span class="material-symbols-outlined text-gray-600 text-2xl">history</span>
                    <h5 class="font-semibold text-gray-800">Riwayat Verifikasi</h5>
                </div>
                <div class="p-6">
                    <?php if (empty($return_history)): ?>
                        <div class="text-center py-8">
                            <p class="text-gray-500">Belum ada riwayat verifikasi</p>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Kode Pinjam</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Mahasiswa</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Diverifikasi Oleh</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Tanggal Verifikasi</th>
                                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Alasan Penolakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($return_history as $history): ?>
                                        <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition-colors">
                                            <td class="py-4 px-4">
                                                <span class="font-semibold text-gray-800"><?= $history['borrow_code'] ?></span>
                                            </td>
                                            <td class="py-4 px-4 text-gray-700"><?= $history['user_name'] ?></td>
                                            <td class="py-4 px-4">
                                                <?php if ($history['status'] === 'returned'): ?>
                                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">
                                                        Disetujui
                                                    </span>
                                                <?php else: ?>
                                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                                        Ditolak
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-4 px-4 text-gray-700"><?= $history['verified_by_name'] ?></td>
                                            <td class="py-4 px-4 text-gray-600"><?= formatDate($history['verified_at']) ?></td>
                                            <td class="py-4 px-4 text-gray-600 text-sm">
                                                <?= $history['rejection_reason'] ?: '-' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-[9999] hidden flex items-center justify-center p-4">
    <div class="glass-card rounded-3xl max-w-md w-full p-6 shadow-2xl" onclick="event.stopPropagation()">
        <div class="flex items-center gap-3 mb-4">
            <span class="material-symbols-outlined text-red-600 text-3xl">cancel</span>
            <h3 class="text-xl font-bold text-gray-800">Tolak Pengembalian</h3>
        </div>
        
        <p class="text-gray-600 mb-4">Kode Pinjam: <span id="rejectBorrowCode" class="font-semibold text-gray-800"></span></p>
        
        <form id="rejectForm" method="POST">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan *</label>
                <textarea name="rejection_reason" required rows="4"
                          class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all resize-none"
                          placeholder="Jelaskan alasan penolakan pengembalian ini..."></textarea>
            </div>
            
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:shadow-lg hover:shadow-red-500/30 transition-all font-medium">
                    Tolak Pengembalian
                </button>
                <button type="button" onclick="closeRejectModal()"
                        class="flex-1 px-6 py-3 glass-card rounded-xl hover-lift text-gray-700 font-medium">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal(returnId, borrowCode) {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectBorrowCode').textContent = borrowCode;
    document.getElementById('rejectForm').action = '<?= BASE_URL ?>return/reject/' + returnId;
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectForm').reset();
}

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>

<?php require_once '../app/views/layouts/footer.php'; ?>
