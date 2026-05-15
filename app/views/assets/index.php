<?php 
/**
 * @var array $assets
 */
require_once '../app/views/layouts/header.php'; 
?>

<div class="flex min-h-screen">
    <?php require_once '../app/views/layouts/sidebar.php'; ?>
    
    <!-- Main Content -->
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

            <!-- Action Button -->
            <div class="flex justify-end">
                <a href="<?= BASE_URL ?>asset/create" class="glass-card px-6 py-3 rounded-xl hover-lift flex items-center gap-2 text-gray-700 hover:text-emerald-600 transition-colors font-medium">
                    <span class="material-symbols-outlined">add</span>
                    Add Asset
                </a>
            </div>

            <!-- Assets Table Card -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/30">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Code</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Available</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Condition</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/20">
                            <?php foreach ($assets as $asset): ?>
                                <tr class="hover:bg-white/20 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= $asset['code'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= $asset['name'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= $asset['category_name'] ?? '-' ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-700"><?= $asset['total_quantity'] ?></td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $asset['available_quantity'] > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' ?>">
                                            <?= $asset['available_quantity'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= $asset['location'] ?></td>
                                    <td class="px-6 py-4">
                                        <?php
                                        $conditionClass = [
                                            'baik' => 'bg-emerald-100 text-emerald-700',
                                            'rusak ringan' => 'bg-amber-100 text-amber-700',
                                            'rusak berat' => 'bg-red-100 text-red-700'
                                        ];
                                        ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?= $conditionClass[$asset['condition']] ?>">
                                            <?= ucfirst($asset['condition']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="<?= BASE_URL ?>asset/edit/<?= $asset['id'] ?>" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/30 text-gray-600 hover:text-amber-600 transition-colors">
                                                <span class="material-symbols-outlined text-lg">edit</span>
                                            </a>
                                            <a href="<?= BASE_URL ?>asset/delete/<?= $asset['id'] ?>" 
                                               class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/30 text-gray-600 hover:text-red-600 transition-colors" 
                                               onclick="return confirmDelete()">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
