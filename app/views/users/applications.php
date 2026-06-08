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

            <div class="glass-card rounded-3xl p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Pengajuan Akun Civitas Elektro</h2>
                        <p class="text-sm text-gray-600 mt-1">Setujui hanya mahasiswa atau dosen elektro yang valid. Akun tidak dibuat sebelum admin menyetujui pengajuan.</p>
                    </div>
                    <a href="<?= BASE_URL ?>user/create" class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl font-medium flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">person_add</span>
                        Buat Akun Manual
                    </a>
                </div>
            </div>

            <div class="glass-card rounded-3xl overflow-hidden">
                <?php if (empty($requests)): ?>
                    <div class="p-12 text-center">
                        <span class="material-symbols-outlined text-6xl text-gray-300 block mb-4">inbox</span>
                        <p class="text-gray-600">Belum ada pengajuan akun mahasiswa.</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[1180px]">
                            <thead>
                                <tr class="border-b border-white/30">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pemohon</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kontak</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Program</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Keperluan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi Admin</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/20">
                                <?php foreach ($requests as $request): ?>
                                    <?php
                                    $statusClass = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'approved' => 'bg-emerald-100 text-emerald-700',
                                        'rejected' => 'bg-red-100 text-red-700'
                                    ];
                                    $statusLabel = [
                                        'pending' => 'Menunggu',
                                        'approved' => 'Disetujui',
                                        'rejected' => 'Ditolak'
                                    ];
                                    ?>
                                    <tr class="hover:bg-white/20 transition-colors align-top">
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-semibold text-gray-900"><?= htmlspecialchars($request['name']) ?></p>
                                            <p class="text-xs text-gray-600 mt-1">Jenis: <?= ucfirst(htmlspecialchars($request['applicant_type'] ?? 'mahasiswa')) ?></p>
                                            <p class="text-xs text-gray-600 mt-1">NIM/NIP: <?= htmlspecialchars($request['nim']) ?></p>
                                            <p class="text-xs text-gray-500 mt-1">Diajukan: <?= formatDateTime($request['created_at']) ?></p>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <p><?= htmlspecialchars($request['email']) ?></p>
                                            <p class="text-xs text-gray-500 mt-1"><?= htmlspecialchars($request['phone'] ?: '-') ?></p>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <p class="font-medium"><?= htmlspecialchars($request['program_studi']) ?></p>
                                            <p class="text-xs text-gray-500 mt-1">Semester: <?= htmlspecialchars($request['semester'] ?: '-') ?></p>
                                            <p class="text-xs text-gray-500 mt-1">Kelas: <?= htmlspecialchars($request['class_name'] ?: '-') ?></p>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 max-w-xs">
                                            <?= nl2br(htmlspecialchars($request['reason'] ?: '-')) ?>
                                            <?php if (!empty($request['admin_notes'])): ?>
                                                <div class="mt-3 p-3 bg-gray-50 rounded-xl border border-gray-200 text-xs">
                                                    <strong>Catatan admin:</strong><br>
                                                    <?= nl2br(htmlspecialchars($request['admin_notes'])) ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $statusClass[$request['status']] ?? 'bg-gray-100 text-gray-600' ?>">
                                                <?= $statusLabel[$request['status']] ?? ucfirst($request['status']) ?>
                                            </span>
                                            <?php if (!empty($request['reviewer_name'])): ?>
                                                <p class="text-xs text-gray-500 mt-2">Oleh: <?= htmlspecialchars($request['reviewer_name']) ?></p>
                                            <?php endif; ?>
                                            <?php if (!empty($request['reviewed_at'])): ?>
                                                <p class="text-xs text-gray-500 mt-1"><?= formatDateTime($request['reviewed_at']) ?></p>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 min-w-[260px]">
                                            <div class="flex items-center gap-2 mb-3">
                                                <a href="<?= BASE_URL ?>user/editApplication/<?= $request['id'] ?>" class="flex-1 px-3 py-2 glass-card rounded-xl text-sm font-medium flex items-center justify-center gap-2">
                                                    <span class="material-symbols-outlined text-base">edit</span>
                                                    Kelola Data
                                                </a>
                                                <a href="<?= BASE_URL ?>user/deleteApplication/<?= $request['id'] ?>" class="px-3 py-2 text-red-700 bg-red-50 border border-red-200 rounded-xl text-sm font-medium flex items-center justify-center" onclick="return confirm('Hapus pengajuan akun ini?')">
                                                    <span class="material-symbols-outlined text-base">delete</span>
                                                </a>
                                            </div>
                                            <?php if ($request['status'] === 'pending'): ?>
                                                <form action="<?= BASE_URL ?>user/approveApplication/<?= $request['id'] ?>" method="POST" class="space-y-2 mb-3">
                                                    <textarea name="admin_notes" rows="2" class="w-full px-3 py-2 form-input rounded-xl text-sm" placeholder="Catatan persetujuan (opsional)"></textarea>
                                                    <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl font-medium flex items-center justify-center gap-2" onclick="return confirm('Setujui pengajuan dan buat akun mahasiswa ini?')">
                                                        <span class="material-symbols-outlined text-lg">check_circle</span>
                                                        Setujui & Buat Akun
                                                    </button>
                                                </form>
                                                <form action="<?= BASE_URL ?>user/rejectApplication/<?= $request['id'] ?>" method="POST" class="space-y-2">
                                                    <textarea name="admin_notes" rows="2" class="w-full px-3 py-2 form-input rounded-xl text-sm" placeholder="Alasan penolakan"></textarea>
                                                    <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-medium flex items-center justify-center gap-2" onclick="return confirm('Tolak pengajuan akun ini?')">
                                                        <span class="material-symbols-outlined text-lg">cancel</span>
                                                        Tolak Pengajuan
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <p class="text-sm text-gray-500">Sudah diproses</p>
                                            <?php endif; ?>
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

<?php require_once '../app/views/layouts/footer.php'; ?>
