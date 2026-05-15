<?php require_once '../app/views/layouts/header.php'; ?>

<div class="flex min-h-screen">
    <?php require_once '../app/views/layouts/sidebar.php'; ?>
    
    <main class="flex-1 lg:ml-64 p-8">
        <?php require_once '../app/views/layouts/navbar.php'; ?>

        <div class="space-y-6">
            <div class="glass-card rounded-3xl p-8">
                <form action="<?= BASE_URL ?>borrow/create" method="POST" id="borrowForm" class="space-y-6">
                    
                    <!-- Tanggal -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pinjam *</label>
                            <input type="date" name="borrow_date" 
                                   class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                   required min="<?= date('Y-m-d') ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kembali *</label>
                            <input type="date" name="return_date" 
                                   class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                   required min="<?= date('Y-m-d') ?>">
                        </div>
                    </div>

                    <!-- Keperluan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keperluan *</label>
                        <textarea name="purpose" rows="3" required
                                  class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all resize-none"
                                  placeholder="Jelaskan keperluan peminjaman..."></textarea>
                    </div>

                    <hr class="border-white/30">

                    <h5 class="text-base font-semibold text-gray-800">Aset yang Dipinjam</h5>

                    <div id="assetItems" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end asset-item">
                            <div class="md:col-span-8">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Aset *</label>
                                <select name="asset_id[]" required
                                        class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all">
                                    <option value="">Pilih Aset</option>
                                    <?php foreach ($assets as $asset): ?>
                                        <option value="<?= $asset['id'] ?>">
                                            <?= $asset['name'] ?> (Tersedia: <?= $asset['available_quantity'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah *</label>
                                <input type="number" name="quantity[]" min="1" required
                                       class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all">
                            </div>
                            <div class="md:col-span-1 flex justify-center">
                                <button type="button" class="remove-item w-9 h-9 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors" style="display:none;">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="addAsset"
                            class="flex items-center gap-2 px-4 py-2 glass-card rounded-xl text-sm font-medium text-gray-700 hover:text-emerald-600 transition-colors">
                        <span class="material-symbols-outlined text-lg">add_circle</span>
                        Tambah Aset
                    </button>

                    <hr class="border-white/30">

                    <div class="flex items-center gap-3">
                        <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all font-medium flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">send</span>
                            Ajukan
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
    </main>
</div>

<script>
document.getElementById('addAsset').addEventListener('click', function() {
    const container = document.getElementById('assetItems');
    const firstItem = container.querySelector('.asset-item');
    const newItem = firstItem.cloneNode(true);
    newItem.querySelectorAll('input, select').forEach(input => input.value = '');
    newItem.querySelector('.remove-item').style.display = 'flex';
    container.appendChild(newItem);
    updateRemoveButtons();
});

document.getElementById('assetItems').addEventListener('click', function(e) {
    if (e.target.closest('.remove-item')) {
        e.target.closest('.asset-item').remove();
        updateRemoveButtons();
    }
});

function updateRemoveButtons() {
    const items = document.querySelectorAll('.asset-item');
    items.forEach((item, index) => {
        const removeBtn = item.querySelector('.remove-item');
        removeBtn.style.display = items.length > 1 ? 'flex' : 'none';
    });
}
</script>

<?php require_once '../app/views/layouts/footer.php'; ?>
