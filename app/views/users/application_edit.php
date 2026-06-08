<?php require_once '../app/views/layouts/header.php'; ?>

<div class="flex min-h-screen">
    <?php require_once '../app/views/layouts/sidebar.php'; ?>
    
    <main class="flex-1 lg:ml-64 p-8">
        <?php require_once '../app/views/layouts/navbar.php'; ?>

        <div class="max-w-4xl mx-auto space-y-6">
            <?php 
            $flash = getFlash();
            if ($flash): 
                $alertColors = [
                    'success' => 'from-emerald-50 to-emerald-100 border-emerald-200 text-emerald-800',
                    'danger' => 'from-red-50 to-red-100 border-red-200 text-red-800',
                    'warning' => 'from-amber-50 to-amber-100 border-amber-200 text-amber-800',
                    'info' => 'from-blue-50 to-blue-100 border-blue-200 text-blue-800'
                ];
                $colorClass = $alertColors[$flash['type']] ?? $alertColors['info'];
            ?>
                <div class="bg-gradient-to-r <?= $colorClass ?> border rounded-2xl p-4 text-sm flex items-center gap-2" data-alert>
                    <span class="material-symbols-outlined text-lg">info</span>
                    <?= $flash['message'] ?>
                </div>
            <?php endif; ?>

            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-900">Kelola Data Pengajuan</h2>
                    <p class="text-sm text-gray-600 mt-1">Perbarui informasi mahasiswa sebelum pengajuan disetujui atau ditolak.</p>
                </div>

                <form action="<?= BASE_URL ?>user/editApplication/<?= $request['id'] ?>" method="POST" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($request['name']) ?>" class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Pemohon *</label>
                        <select name="applicant_type" class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" required>
                            <option value="mahasiswa" <?= ($request['applicant_type'] ?? 'mahasiswa') === 'mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
                            <option value="dosen" <?= ($request['applicant_type'] ?? 'mahasiswa') === 'dosen' ? 'selected' : '' ?>>Dosen</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NIM / NIP *</label>
                        <input type="text" name="nim" value="<?= htmlspecialchars($request['nim']) ?>" class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($request['email']) ?>" class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. HP / WhatsApp</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($request['phone'] ?? '') ?>" class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Program Studi Elektro *</label>
                        <select name="program_studi" class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" required>
                            <?php
                            $programs = [
                                'Teknik Listrik D3',
                                'Teknik Informatika D4',
                                'Teknologi Rekayasa Sistem Kelistrikan Minyak dan Gas D4'
                            ];
                            foreach ($programs as $program):
                            ?>
                                <option value="<?= $program ?>" <?= $request['program_studi'] === $program ? 'selected' : '' ?>><?= $program ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                        <select name="semester" class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all">
                            <option value="">Pilih semester</option>
                            <?php for ($i = 1; $i <= 8; $i++): ?>
                                <option value="<?= $i ?>" <?= (string) $request['semester'] === (string) $i ? 'selected' : '' ?>>Semester <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Khusus mahasiswa. Untuk dosen boleh dikosongkan.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                        <input type="text" name="class_name" value="<?= htmlspecialchars($request['class_name'] ?? '') ?>" class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all">
                        <p class="text-xs text-gray-500 mt-1">Khusus mahasiswa. Untuk dosen boleh dikosongkan.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keperluan Akses</label>
                        <textarea name="reason" rows="4" class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all resize-none"><?= htmlspecialchars($request['reason'] ?? '') ?></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                        <textarea name="admin_notes" rows="3" class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all resize-none"><?= htmlspecialchars($request['admin_notes'] ?? '') ?></textarea>
                    </div>

                    <div class="md:col-span-2 flex flex-wrap items-center gap-3 pt-3">
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl font-medium flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">save</span>
                            Simpan Perubahan
                        </button>
                        <a href="<?= BASE_URL ?>user/applications" class="px-6 py-3 glass-card rounded-xl hover-lift text-gray-700 font-medium flex items-center gap-2">
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
