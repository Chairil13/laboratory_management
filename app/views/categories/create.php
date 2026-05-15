<?php require_once '../app/views/layouts/header.php'; ?>

<div class="flex min-h-screen">
    <?php require_once '../app/views/layouts/sidebar.php'; ?>
    
    <main class="flex-1 lg:ml-64 p-8">
        <?php require_once '../app/views/layouts/navbar.php'; ?>

        <div class="max-w-2xl mx-auto space-y-6">
            <!-- Header -->
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Tambah Kategori</h1>
                <p class="text-gray-600 mt-1">Buat kategori baru untuk mengorganisir aset laboratorium</p>
            </div>

            <!-- Form Card -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/30">
                    <h5 class="font-semibold text-gray-800">Form Kategori Baru</h5>
                </div>
                <div class="p-6">
                    <form action="<?= BASE_URL ?>category/create" method="POST" class="space-y-5">
                        
                        <!-- Category Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Kategori *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   required
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
                                      placeholder="Jelaskan kategori ini untuk apa..."></textarea>
                            <p class="text-xs text-gray-500 mt-1">Opsional - Deskripsi singkat tentang kategori ini</p>
                        </div>

                        <!-- Info Box -->
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-start gap-3">
                            <span class="material-symbols-outlined text-blue-600 text-xl">info</span>
                            <div class="flex-1">
                                <p class="text-sm text-blue-800 font-medium">Tips Kategori</p>
                                <ul class="text-sm text-blue-700 mt-1 space-y-1 list-disc list-inside">
                                    <li>Gunakan nama yang jelas dan mudah dipahami</li>
                                    <li>Kategori akan muncul saat menambah aset baru</li>
                                    <li>Kategori tidak bisa dihapus jika masih ada aset</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all font-medium flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">check_circle</span>
                                Simpan Kategori
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
