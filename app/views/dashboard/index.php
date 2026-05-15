<?php require_once '../app/views/layouts/header.php'; ?>

<div class="flex min-h-screen">
    <?php require_once '../app/views/layouts/sidebar.php'; ?>
    
    <!-- Main Content -->
    <main class="flex-1 lg:ml-64 p-8">
        <?php require_once '../app/views/layouts/navbar.php'; ?>
        
        <div class="space-y-8">
            
            <!-- Flash Message -->
            <?php 
            $flash = getFlash();
            if ($flash): 
                $alertColors = [
                    'success' => 'bg-green-50 border-green-200 text-green-800',
                    'danger' => 'bg-red-50 border-red-200 text-red-800',
                    'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
                    'info' => 'bg-blue-50 border-blue-200 text-blue-800'
                ];
                $colorClass = $alertColors[$flash['type']] ?? $alertColors['info'];
            ?>
                <div class="<?= $colorClass ?> border rounded-lg p-4 text-sm flex items-center gap-2" data-alert>
                    <span class="material-symbols-outlined text-lg">info</span>
                    <?= $flash['message'] ?>
                </div>
            <?php endif; ?>

            <!-- Statistics Cards with Glassmorphism -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Total Assets -->
                <div class="glass-stat rounded-3xl p-6 hover-lift group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-slate-400 to-slate-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-2xl transition-all duration-300">
                            <span class="material-symbols-outlined text-white text-3xl">inventory_2</span>
                        </div>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Total Assets</p>
                    <h3 class="text-4xl font-bold text-gray-900 mb-1"><?= $total_assets ?? 0 ?></h3>
                    <p class="text-xs text-gray-500">Registered items</p>
                </div>

                <!-- Available -->
                <div class="glass-stat rounded-3xl p-6 hover-lift hover-glow group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center shadow-xl shadow-emerald-500/30 group-hover:shadow-2xl group-hover:shadow-emerald-500/40 transition-all duration-300">
                            <span class="material-symbols-outlined text-white text-3xl">check_circle</span>
                        </div>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Available</p>
                    <h3 class="text-4xl font-bold text-gray-900 mb-1"><?= $available_assets ?? 0 ?></h3>
                    <p class="text-xs text-gray-500">Ready to borrow</p>
                </div>

                <!-- In Use -->
                <div class="glass-stat rounded-3xl p-6 hover-lift group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center shadow-xl shadow-amber-500/30 group-hover:shadow-2xl group-hover:shadow-amber-500/40 transition-all duration-300">
                            <span class="material-symbols-outlined text-white text-3xl">shopping_bag</span>
                        </div>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">In Use</p>
                    <h3 class="text-4xl font-bold text-gray-900 mb-1"><?= $borrowed_assets ?? 0 ?></h3>
                    <p class="text-xs text-gray-500">Currently borrowed</p>
                </div>

                <!-- Pending -->
                <div class="glass-stat rounded-3xl p-6 hover-lift group <?= ($pending_requests ?? 0) > 0 ? 'ring-2 ring-violet-400 ring-offset-2' : '' ?>">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-violet-400 to-violet-600 rounded-2xl flex items-center justify-center shadow-xl shadow-violet-500/30 group-hover:shadow-2xl group-hover:shadow-violet-500/40 transition-all duration-300 <?= ($pending_requests ?? 0) > 0 ? 'animate-pulse' : '' ?>">
                            <span class="material-symbols-outlined text-white text-3xl">pending_actions</span>
                        </div>
                        <?php if (($pending_requests ?? 0) > 0 && getUserRole() === 'kepala_lab'): ?>
                            <span class="flex items-center gap-1 px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-full animate-pulse">
                                <span class="material-symbols-outlined text-xs">notification_important</span>
                                New
                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Pending</p>
                    <h3 class="text-4xl font-bold text-gray-900 mb-1"><?= $pending_requests ?? 0 ?></h3>
                    <p class="text-xs text-gray-500">Awaiting approval</p>
                </div>
            </div>

            <!-- Role Specific Content -->
            <?php if (getUserRole() === 'user' && isset($my_borrowings)): ?>
                <div class="bg-surface rounded-xl border border-border shadow-sm">
                    <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                        <h2 class="font-heading text-lg font-semibold text-text-primary">Peminjaman Saya</h2>
                        <a href="<?= BASE_URL ?>borrow/create" class="text-sm text-primary hover:text-primary-container font-medium flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">add</span>
                            Ajukan Baru
                        </a>
                    </div>
                    <div class="p-6">
                        <?php if (empty($my_borrowings)): ?>
                            <div class="text-center py-12">
                                <span class="material-symbols-outlined text-6xl text-outline mb-4">inbox</span>
                                <p class="text-text-secondary">Belum ada peminjaman</p>
                            </div>
                        <?php else: ?>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="border-b border-border text-left">
                                            <th class="pb-3 text-xs font-semibold text-text-secondary uppercase tracking-wider">Kode</th>
                                            <th class="pb-3 text-xs font-semibold text-text-secondary uppercase tracking-wider">Tanggal Pinjam</th>
                                            <th class="pb-3 text-xs font-semibold text-text-secondary uppercase tracking-wider">Tanggal Kembali</th>
                                            <th class="pb-3 text-xs font-semibold text-text-secondary uppercase tracking-wider">Status</th>
                                            <th class="pb-3 text-xs font-semibold text-text-secondary uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-border">
                                        <?php foreach ($my_borrowings as $borrow): ?>
                                            <tr class="hover:bg-background transition-colors">
                                                <td class="py-4 text-sm font-medium text-text-primary"><?= $borrow['borrow_code'] ?></td>
                                                <td class="py-4 text-sm text-text-secondary"><?= formatDate($borrow['borrow_date']) ?></td>
                                                <td class="py-4 text-sm text-text-secondary"><?= formatDate($borrow['return_date']) ?></td>
                                                <td class="py-4">
                                                    <?php
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'approved' => 'bg-green-100 text-green-800',
                                                        'rejected' => 'bg-red-100 text-red-800',
                                                        'returned' => 'bg-blue-100 text-blue-800',
                                                        'cancelled' => 'bg-gray-100 text-gray-800',
                                                        'pending_return' => 'bg-purple-100 text-purple-800'
                                                    ];
                                                    $statusColor = isset($statusColors[$borrow['status']]) ? $statusColors[$borrow['status']] : 'bg-gray-100 text-gray-800';
                                                    ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusColor ?>">
                                                        <?= ucfirst(str_replace('_', ' ', $borrow['status'])) ?>
                                                    </span>
                                                </td>
                                                <td class="py-4">
                                                    <a href="<?= BASE_URL ?>borrow/detail/<?= $borrow['id'] ?>" class="text-primary hover:text-primary-container">
                                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Available Assets Section for Students -->
                <?php if (isset($available_assets_list)): ?>
                <div class="bg-surface rounded-xl border border-border shadow-sm">
                    <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                        <div>
                            <h2 class="font-heading text-lg font-semibold text-text-primary">Alat yang Tersedia</h2>
                            <p class="text-xs text-gray-500 mt-1">Daftar alat laboratorium yang dapat dipinjam</p>
                        </div>
                        <a href="<?= BASE_URL ?>borrow/create" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-sm font-medium rounded-lg hover:shadow-lg hover:shadow-emerald-500/30 transition-all flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                            Pinjam Alat
                        </a>
                    </div>
                    <div class="p-6">
                        <?php if (empty($available_assets_list)): ?>
                            <div class="text-center py-12">
                                <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">inventory_2</span>
                                <p class="text-gray-500">Tidak ada alat yang tersedia saat ini</p>
                            </div>
                        <?php else: ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <?php foreach ($available_assets_list as $asset): ?>
                                    <div class="glass-card rounded-2xl p-5 hover-lift">
                                        <!-- Asset Header -->
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                                    <span class="material-symbols-outlined text-white text-2xl">inventory_2</span>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-800 text-sm"><?= htmlspecialchars($asset['name']) ?></h3>
                                                    <p class="text-xs text-gray-500"><?= htmlspecialchars($asset['code']) ?></p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Category Badge -->
                                        <?php if ($asset['category_name']): ?>
                                            <div class="mb-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <span class="material-symbols-outlined text-xs mr-1">category</span>
                                                    <?= htmlspecialchars($asset['category_name']) ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Asset Info -->
                                        <div class="space-y-2 mb-4">
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-600">Tersedia:</span>
                                                <span class="font-semibold text-emerald-600"><?= $asset['available_quantity'] ?> unit</span>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-600">Total:</span>
                                                <span class="font-medium text-gray-800"><?= $asset['total_quantity'] ?> unit</span>
                                            </div>
                                            <?php if ($asset['location']): ?>
                                                <div class="flex items-start gap-2 text-sm">
                                                    <span class="material-symbols-outlined text-gray-400 text-base">location_on</span>
                                                    <span class="text-gray-600 text-xs"><?= htmlspecialchars($asset['location']) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Condition Badge -->
                                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                            <?php
                                            $conditionColors = [
                                                'baik' => 'bg-green-100 text-green-800',
                                                'rusak ringan' => 'bg-yellow-100 text-yellow-800',
                                                'rusak berat' => 'bg-red-100 text-red-800'
                                            ];
                                            $conditionIcons = [
                                                'baik' => 'check_circle',
                                                'rusak ringan' => 'warning',
                                                'rusak berat' => 'error'
                                            ];
                                            ?>
                                            <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-medium <?= $conditionColors[$asset['condition']] ?>">
                                                <span class="material-symbols-outlined text-xs mr-1"><?= $conditionIcons[$asset['condition']] ?></span>
                                                <?= ucfirst($asset['condition']) ?>
                                            </span>
                                            <a href="<?= BASE_URL ?>borrow/create" class="text-emerald-600 hover:text-emerald-700 text-xs font-medium flex items-center gap-1">
                                                Pinjam
                                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (getUserRole() === 'kepala_lab' && isset($pending_approvals)): ?>
                <div class="bg-surface rounded-xl border border-border shadow-sm">
                    <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                        <h2 class="font-heading text-lg font-semibold text-text-primary">Pengajuan Pending</h2>
                        <a href="<?= BASE_URL ?>approval" class="text-sm text-primary hover:text-primary-container font-medium">
                            Lihat Semua →
                        </a>
                    </div>
                    <div class="p-6">
                        <?php if (empty($pending_approvals)): ?>
                            <div class="text-center py-12">
                                <span class="material-symbols-outlined text-6xl text-outline mb-4">task_alt</span>
                                <p class="text-text-secondary">Tidak ada pengajuan pending</p>
                            </div>
                        <?php else: ?>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="border-b border-border text-left">
                                            <th class="pb-3 text-xs font-semibold text-text-secondary uppercase tracking-wider">Kode</th>
                                            <th class="pb-3 text-xs font-semibold text-text-secondary uppercase tracking-wider">Peminjam</th>
                                            <th class="pb-3 text-xs font-semibold text-text-secondary uppercase tracking-wider">Tanggal</th>
                                            <th class="pb-3 text-xs font-semibold text-text-secondary uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-border">
                                        <?php foreach ($pending_approvals as $approval): ?>
                                            <tr class="hover:bg-background transition-colors">
                                                <td class="py-4 text-sm font-medium text-text-primary"><?= $approval['borrow_code'] ?></td>
                                                <td class="py-4 text-sm text-text-secondary"><?= $approval['user_name'] ?></td>
                                                <td class="py-4 text-sm text-text-secondary"><?= formatDate($approval['borrow_date']) ?></td>
                                                <td class="py-4">
                                                    <a href="<?= BASE_URL ?>approval" class="inline-flex items-center gap-1 px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-sm font-medium rounded-lg hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
                                                        Review
                                                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Admin Quick Actions -->
            <?php if (getUserRole() === 'admin'): ?>
                <!-- Welcome Section -->
                <div class="bg-gradient-to-r from-gray-50 to-slate-100 rounded-2xl p-8 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome back, <?= getUserName() ?>! 👋</h2>
                            <p class="text-gray-600">Here's what's happening with your laboratory today.</p>
                        </div>
                        <div class="hidden md:block">
                            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg">
                                <span class="material-symbols-outlined text-4xl text-gray-700" style="font-variation-settings: 'FILL' 1;">admin_panel_settings</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Add Asset Card -->
                    <a href="<?= BASE_URL ?>asset/create" class="group bg-white rounded-2xl p-6 border border-gray-200 hover:border-emerald-300 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                                <span class="material-symbols-outlined text-emerald-600 text-2xl">add_box</span>
                            </div>
                            <span class="material-symbols-outlined text-gray-400 group-hover:text-emerald-600 transition-colors">arrow_forward</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Add New Asset</h3>
                        <p class="text-sm text-gray-500">Register new laboratory equipment and resources</p>
                    </a>

                    <!-- Add User Card -->
                    <a href="<?= BASE_URL ?>user/create" class="group bg-white rounded-2xl p-6 border border-gray-200 hover:border-violet-300 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 bg-violet-50 rounded-xl flex items-center justify-center group-hover:bg-violet-100 transition-colors">
                                <span class="material-symbols-outlined text-violet-600 text-2xl">person_add</span>
                            </div>
                            <span class="material-symbols-outlined text-gray-400 group-hover:text-violet-600 transition-colors">arrow_forward</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Add New User</h3>
                        <p class="text-sm text-gray-500">Create accounts for students and staff members</p>
                    </a>

                    <!-- Manage Assets Card -->
                    <a href="<?= BASE_URL ?>asset" class="group bg-white rounded-2xl p-6 border border-gray-200 hover:border-amber-300 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                                <span class="material-symbols-outlined text-amber-600 text-2xl">inventory</span>
                            </div>
                            <span class="material-symbols-outlined text-gray-400 group-hover:text-amber-600 transition-colors">arrow_forward</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Manage Assets</h3>
                        <p class="text-sm text-gray-500">View, edit, and organize laboratory assets</p>
                    </a>
                </div>

                <!-- System Overview & Recent Activity -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- System Overview -->
                    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">System Overview</h3>
                            <p class="text-sm text-gray-500 mt-1">Real-time statistics and metrics</p>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Stat Item -->
                                <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 rounded-xl p-5 border border-slate-200">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                            <span class="material-symbols-outlined text-slate-600">inventory_2</span>
                                        </div>
                                        <span class="text-xs font-medium text-slate-900 uppercase tracking-wider">Total Assets</span>
                                    </div>
                                    <div class="flex items-end justify-between">
                                        <div>
                                            <p class="text-3xl font-bold text-slate-900"><?= $total_assets ?? 0 ?></p>
                                            <p class="text-xs text-slate-700 mt-1">Registered items</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stat Item -->
                                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-xl p-5 border border-emerald-200">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                            <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                                        </div>
                                        <span class="text-xs font-medium text-emerald-900 uppercase tracking-wider">Available</span>
                                    </div>
                                    <div class="flex items-end justify-between">
                                        <div>
                                            <p class="text-3xl font-bold text-emerald-900"><?= $available_assets ?? 0 ?></p>
                                            <p class="text-xs text-emerald-700 mt-1">Ready to borrow</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stat Item -->
                                <div class="bg-gradient-to-br from-amber-50 to-amber-100/50 rounded-xl p-5 border border-amber-200">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                            <span class="material-symbols-outlined text-amber-600">shopping_bag</span>
                                        </div>
                                        <span class="text-xs font-medium text-amber-900 uppercase tracking-wider">In Use</span>
                                    </div>
                                    <div class="flex items-end justify-between">
                                        <div>
                                            <p class="text-3xl font-bold text-amber-900"><?= $borrowed_assets ?? 0 ?></p>
                                            <p class="text-xs text-amber-700 mt-1">Currently borrowed</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stat Item -->
                                <div class="bg-gradient-to-br from-violet-50 to-violet-100/50 rounded-xl p-5 border border-violet-200">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                            <span class="material-symbols-outlined text-violet-600">pending_actions</span>
                                        </div>
                                        <span class="text-xs font-medium text-violet-900 uppercase tracking-wider">Pending</span>
                                    </div>
                                    <div class="flex items-end justify-between">
                                        <div>
                                            <p class="text-3xl font-bold text-violet-900"><?= $pending_requests ?? 0 ?></p>
                                            <p class="text-xs text-violet-700 mt-1">Awaiting approval</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">Quick Links</h3>
                            <p class="text-sm text-gray-500 mt-1">Frequently accessed pages</p>
                        </div>
                        <div class="p-4">
                            <div class="space-y-2">
                                <a href="<?= BASE_URL ?>asset" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors group">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-slate-100 transition-colors">
                                        <span class="material-symbols-outlined text-gray-600 text-lg group-hover:text-slate-700">inventory_2</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">All Assets</p>
                                        <p class="text-xs text-gray-500">View inventory</p>
                                    </div>
                                    <span class="material-symbols-outlined text-gray-400 text-lg">chevron_right</span>
                                </a>

                                <a href="<?= BASE_URL ?>user" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors group">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-violet-100 transition-colors">
                                        <span class="material-symbols-outlined text-gray-600 text-lg group-hover:text-violet-600">group</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">All Users</p>
                                        <p class="text-xs text-gray-500">Manage accounts</p>
                                    </div>
                                    <span class="material-symbols-outlined text-gray-400 text-lg">chevron_right</span>
                                </a>

                                <a href="<?= BASE_URL ?>borrow" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors group">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                                        <span class="material-symbols-outlined text-gray-600 text-lg group-hover:text-amber-600">list_alt</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Borrowings</p>
                                        <p class="text-xs text-gray-500">View all requests</p>
                                    </div>
                                    <span class="material-symbols-outlined text-gray-400 text-lg">chevron_right</span>
                                </a>

                                <a href="<?= BASE_URL ?>report" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition-colors group">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                                        <span class="material-symbols-outlined text-gray-600 text-lg group-hover:text-emerald-600">bar_chart</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Reports</p>
                                        <p class="text-xs text-gray-500">Analytics & stats</p>
                                    </div>
                                    <span class="material-symbols-outlined text-gray-400 text-lg">chevron_right</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
