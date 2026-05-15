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

            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Kelola Kategori</h1>
                    <p class="text-gray-600 mt-1">Manage asset categories for better organization</p>
                </div>
                <a href="<?= BASE_URL ?>category/create" class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all font-medium flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">add</span>
                    Tambah Kategori
                </a>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($categories as $category): ?>
                    <div class="glass-card rounded-3xl overflow-hidden hover-lift">
                        <div class="p-6">
                            <!-- Category Icon & Name -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <span class="material-symbols-outlined text-white text-2xl">category</span>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 text-lg"><?= htmlspecialchars($category['name']) ?></h3>
                                        <p class="text-xs text-gray-500"><?= $category['asset_count'] ?> aset</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                <?= htmlspecialchars($category['description'] ?: 'Tidak ada deskripsi') ?>
                            </p>

                            <!-- Stats -->
                            <div class="flex items-center gap-2 mb-4 p-3 bg-gray-50 rounded-xl">
                                <span class="material-symbols-outlined text-emerald-600 text-lg">inventory_2</span>
                                <span class="text-sm text-gray-700">
                                    <strong><?= $category['asset_count'] ?></strong> aset terdaftar
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                                <a href="<?= BASE_URL ?>category/edit/<?= $category['id'] ?>" 
                                   class="flex-1 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium flex items-center justify-center gap-1">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                    Edit
                                </a>
                                <a href="<?= BASE_URL ?>category/delete/<?= $category['id'] ?>" 
                                   onclick="return confirm('Yakin ingin menghapus kategori ini? <?= $category['asset_count'] > 0 ? 'Kategori ini memiliki ' . $category['asset_count'] . ' aset.' : '' ?>')"
                                   class="flex-1 px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium flex items-center justify-center gap-1">
                                    <span class="material-symbols-outlined text-base">delete</span>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($categories)): ?>
                    <div class="col-span-full text-center py-12">
                        <span class="material-symbols-outlined text-gray-300 text-6xl block mb-4">category</span>
                        <p class="text-gray-500">Belum ada kategori. Tambahkan kategori pertama Anda!</p>
                        <a href="<?= BASE_URL ?>category/create" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all font-medium">
                            <span class="material-symbols-outlined text-lg">add</span>
                            Tambah Kategori
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
