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
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <div class="flex gap-3">
                            <span class="text-sm font-medium text-gray-500 w-36 shrink-0">Kode</span>
                            <span class="text-sm text-gray-900 font-semibold"><?= $borrowing['borrow_code'] ?></span>
                        </div>
                        <div class="flex gap-3">
                            <span class="text-sm font-medium text-gray-500 w-36 shrink-0">Tanggal Pinjam</span>
                            <span class="text-sm text-gray-900"><?= formatDate($borrowing['borrow_date']) ?></span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex gap-3">
                            <span class="text-sm font-medium text-gray-500 w-36 shrink-0">Tanggal Kembali</span>
                            <span class="text-sm text-gray-900"><?= formatDate($borrowing['return_date']) ?></span>
                        </div>
                        <div class="flex gap-3">
                            <span class="text-sm font-medium text-gray-500 w-36 shrink-0">Keperluan</span>
                            <span class="text-sm text-gray-900"><?= $borrowing['purpose'] ?></span>
                        </div>
                    </div>

                    <div class="md:col-span-2 mt-2">
                        <p class="text-sm font-medium text-gray-700 mb-2">Aset yang Dipinjam:</p>
                        <ul class="space-y-1">
                            <?php foreach ($details as $detail): ?>
                                <li class="flex items-center gap-2 text-sm text-gray-700">
                                    <span class="material-symbols-outlined text-emerald-500 text-base">inventory_2</span>
                                    <?= $detail['asset_name'] ?> — Jumlah: <strong><?= $detail['quantity'] ?></strong>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Form Pengembalian -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/30">
                    <h5 class="font-semibold text-gray-800">Form Pengembalian</h5>
                </div>
                <div class="p-6">
                    <!-- Info Alert -->
                    <div class="mb-5 p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-start gap-3">
                        <span class="material-symbols-outlined text-blue-600 text-xl">info</span>
                        <div class="flex-1">
                            <p class="text-sm text-blue-800 font-medium">Informasi Penting</p>
                            <p class="text-sm text-blue-700 mt-1">Pengembalian Anda akan diverifikasi oleh admin terlebih dahulu. Pastikan kondisi aset sesuai dengan yang Anda laporkan.</p>
                        </div>
                    </div>

                    <form action="<?= BASE_URL ?>return/create/<?= $borrowing['id'] ?>" method="POST" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kondisi Aset *</label>
                            <select name="condition" required
                                    class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all">
                                <option value="baik">Baik</option>
                                <option value="rusak ringan">Rusak Ringan</option>
                                <option value="rusak berat">Rusak Berat</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                            <textarea name="notes" rows="3"
                                      class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all resize-none"
                                      placeholder="Tambahkan catatan jika ada kerusakan atau hal lain yang perlu disampaikan"></textarea>
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all font-medium flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">check_circle</span>
                                Konfirmasi Pengembalian
                            </button>
                            <a href="<?= BASE_URL ?>borrow"
                               class="px-6 py-3 glass-card rounded-xl hover-lift text-gray-700 font-medium flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">arrow_back</span>
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
