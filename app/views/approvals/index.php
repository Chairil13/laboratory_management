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

            <div class="glass-card rounded-3xl overflow-hidden">
                <?php if (empty($borrowings)): ?>
                    <div class="p-12 text-center text-gray-500">
                        <span class="material-symbols-outlined text-5xl block mb-2 text-gray-300">task_alt</span>
                        Tidak ada pengajuan yang perlu di-approve
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-white/30">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Pinjam</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Kembali</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Keperluan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/20">
                                <?php foreach ($borrowings as $borrow): ?>
                                    <tr class="hover:bg-white/20 transition-colors">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= $borrow['borrow_code'] ?></td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-medium text-gray-900"><?= $borrow['user_name'] ?></p>
                                            <p class="text-xs text-gray-500"><?= $borrow['nim_nip'] ?></p>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700"><?= formatDate($borrow['borrow_date']) ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-700"><?= formatDate($borrow['return_date']) ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= substr($borrow['purpose'], 0, 50) ?>...</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="<?= BASE_URL ?>borrow/detail/<?= $borrow['id'] ?>" 
                                                   class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/30 text-gray-600 hover:text-sky-600 transition-colors">
                                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                                </a>
                                                <button type="button" onclick="openModal('approve-<?= $borrow['id'] ?>')"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-500 text-white text-xs font-medium rounded-lg hover:bg-emerald-600 transition-colors">
                                                    <span class="material-symbols-outlined text-sm">check</span>
                                                    Setuju
                                                </button>
                                                <button type="button" onclick="openModal('reject-<?= $borrow['id'] ?>')"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-500 text-white text-xs font-medium rounded-lg hover:bg-red-600 transition-colors">
                                                    <span class="material-symbols-outlined text-sm">close</span>
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
    </main>
</div>

<!-- Modals (outside table for proper positioning) -->
<?php if (!empty($borrowings)): ?>
    <?php foreach ($borrowings as $borrow): ?>
        <!-- Approve Modal -->
        <div id="approve-<?= $borrow['id'] ?>" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4" onclick="if(event.target === this) closeModal('approve-<?= $borrow['id'] ?>')">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h5 class="font-semibold text-gray-900">Setujui Peminjaman</h5>
                    <button type="button" onclick="closeModal('approve-<?= $borrow['id'] ?>')" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-500">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <form action="<?= BASE_URL ?>approval/approve/<?= $borrow['id'] ?>" method="POST">
                    <div class="p-6 space-y-4">
                        <p class="text-sm text-gray-700">Apakah Anda yakin ingin menyetujui peminjaman <strong><?= $borrow['borrow_code'] ?></strong>?</p>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none"></textarea>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                        <button type="button" onclick="closeModal('approve-<?= $borrow['id'] ?>')"
                                class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Batal</button>
                        <button type="submit"
                                class="px-5 py-2.5 bg-emerald-500 text-white rounded-xl text-sm font-medium hover:bg-emerald-600 transition-colors shadow-sm">Setujui</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reject Modal -->
        <div id="reject-<?= $borrow['id'] ?>" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4" onclick="if(event.target === this) closeModal('reject-<?= $borrow['id'] ?>')">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h5 class="font-semibold text-gray-900">Tolak Peminjaman</h5>
                    <button type="button" onclick="closeModal('reject-<?= $borrow['id'] ?>')" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-500">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <form action="<?= BASE_URL ?>approval/reject/<?= $borrow['id'] ?>" method="POST">
                    <div class="p-6 space-y-4">
                        <p class="text-sm text-gray-700">Apakah Anda yakin ingin menolak peminjaman <strong><?= $borrow['borrow_code'] ?></strong>?</p>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan *</label>
                            <textarea name="notes" rows="3" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all resize-none"></textarea>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                        <button type="button" onclick="closeModal('reject-<?= $borrow['id'] ?>')"
                                class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Batal</button>
                        <button type="submit"
                                class="px-5 py-2.5 bg-red-500 text-white rounded-xl text-sm font-medium hover:bg-red-600 transition-colors shadow-sm">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<script>
function openModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>

<?php require_once '../app/views/layouts/footer.php'; ?>
