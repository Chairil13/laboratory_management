<?php 
/**
 * @var array $asset
 * @var array $categories
 */
require_once '../app/views/layouts/header.php'; 
?>

<div class="flex min-h-screen">
    <?php require_once '../app/views/layouts/sidebar.php'; ?>
    
    <!-- Main Content -->
    <main class="flex-1 lg:ml-64 p-8">
        <?php require_once '../app/views/layouts/navbar.php'; ?>

        <div class="space-y-6">
            <!-- Form Card -->
            <div class="glass-card rounded-3xl p-8">
                <form action="<?= BASE_URL ?>asset/edit/<?= $asset['id'] ?>" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kode Aset -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kode Aset *</label>
                            <input 
                                type="text" 
                                name="code" 
                                value="<?= $asset['code'] ?>"
                                class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                required
                            />
                        </div>

                        <!-- Nama Aset -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Aset *</label>
                            <input 
                                type="text" 
                                name="name" 
                                value="<?= $asset['name'] ?>"
                                class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                required
                            />
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                            <select 
                                name="category_id" 
                                class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                required
                            >
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $asset['category_id'] ? 'selected' : '' ?>>
                                        <?= $category['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Jumlah Total -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Total *</label>
                            <input 
                                type="number" 
                                name="total_quantity" 
                                value="<?= $asset['total_quantity'] ?>"
                                min="1" 
                                class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                required
                            />
                            <p class="text-xs text-gray-500 mt-1">Tersedia saat ini: <?= $asset['available_quantity'] ?></p>
                        </div>

                        <!-- Lokasi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi *</label>
                            <input 
                                type="text" 
                                name="location" 
                                value="<?= $asset['location'] ?>"
                                class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                required
                            />
                        </div>

                        <!-- Kondisi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kondisi *</label>
                            <select 
                                name="condition" 
                                class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                required
                            >
                                <option value="baik" <?= $asset['condition'] == 'baik' ? 'selected' : '' ?>>Baik</option>
                                <option value="rusak ringan" <?= $asset['condition'] == 'rusak ringan' ? 'selected' : '' ?>>Rusak Ringan</option>
                                <option value="rusak berat" <?= $asset['condition'] == 'rusak berat' ? 'selected' : '' ?>>Rusak Berat</option>
                            </select>
                        </div>

                        <!-- Deskripsi -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea 
                                name="description" 
                                rows="3" 
                                class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all resize-none"
                            ><?= $asset['description'] ?></textarea>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-3 pt-4">
                        <button 
                            type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all font-medium flex items-center gap-2"
                        >
                            <span class="material-symbols-outlined text-lg">save</span>
                            Update
                        </button>
                        <a 
                            href="<?= BASE_URL ?>asset" 
                            class="px-6 py-3 glass-card rounded-xl hover-lift text-gray-700 font-medium flex items-center gap-2"
                        >
                            <span class="material-symbols-outlined text-lg">arrow_back</span>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
