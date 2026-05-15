<?php require_once '../app/views/layouts/header.php'; ?>

<div class="flex min-h-screen">
    <?php require_once '../app/views/layouts/sidebar.php'; ?>
    
    <main class="flex-1 lg:ml-64 p-8">
        <?php require_once '../app/views/layouts/navbar.php'; ?>

        <div class="max-w-2xl mx-auto space-y-6">
            <!-- Header -->
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Edit Kategori</h1>
                <p class="text-gray-600 mt-1">Update informasi kategori aset</p>
            </div>

            <!-- Form Card -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/30">
                    <h5 class="font-semibold text-gray-800">Form Edit Kategori</h5>
                </div>
                <div class="p-6">
                    <form action="<?= BASE_URL ?>category/edit/<?= $category['id'] ?>" method="POST" class="space-y-5">
                        
                        <!-- Category Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Kategori *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   required
                                   value="<?= htmlspecialchars($category['name']) ?>"
                                   class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all"
                                   placeholder="Contoh: Elektronik, Kimia, Komputer">
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="description" 
                                      rows="4"
                                      class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all resize-none"
                                      placeholder="Jelaskan kategori ini untuk apa..."><?= htmlspecialchars($category['description']) ?></textarea>
                            <p class="text-xs text-gray-500 mt-1">Opsional - Deskripsi singkat tentang kategori ini</p>
                        </div>

                        <!-- Info Box -->
                        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-start gap-3">
                            <span class="material-symbols-outlined text-amber-600 text-xl">warning</span>
                            <div class="flex-1">
                                <p class="text-sm text-amber-800 font-medium">Perhatian</p>
                                <p class="text-sm text-amber-700 mt-1">
                                    Perubahan nama kategori akan mempengaruhi semua aset yang menggunakan kategori ini.
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all font-medium flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">save</span>
                                Update Kategori
                            </button>
                            <a href="<?= BASE_URL ?>category"
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
