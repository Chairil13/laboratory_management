<!-- Glassmorphism Sidebar -->
<aside id="sidebar" class="fixed left-0 top-0 h-screen w-64 glass-sidebar z-50 transition-transform duration-300 lg:translate-x-0 -translate-x-full">
    
    <!-- Logo -->
    <div class="flex items-center gap-3 p-6 border-b border-white/20">
        <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
            <span class="material-symbols-outlined text-white text-2xl">science</span>
        </div>
        <div>
            <h2 class="text-base font-semibold text-gray-800">Lab System</h2>
            <p class="text-xs text-gray-600">Smart Management</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="p-4 space-y-1">
        <a href="<?= BASE_URL ?>dashboard" class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/30 transition-all duration-300 <?= strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'bg-white/40 shadow-sm' : '' ?>">
            <span class="material-symbols-outlined text-xl text-gray-700 group-hover:text-emerald-600 transition-colors">dashboard</span>
            <span class="font-medium text-gray-700 group-hover:text-gray-900 text-sm">Dashboard</span>
        </a>

        <?php if (getUserRole() === 'admin'): ?>
            <a href="<?= BASE_URL ?>asset" class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/30 transition-all duration-300 <?= strpos($_SERVER['REQUEST_URI'], 'asset') !== false ? 'bg-white/40 shadow-sm' : '' ?>">
                <span class="material-symbols-outlined text-xl text-gray-700 group-hover:text-emerald-600 transition-colors">inventory_2</span>
                <span class="font-medium text-gray-700 group-hover:text-gray-900 text-sm">Assets</span>
            </a>
            <a href="<?= BASE_URL ?>category" class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/30 transition-all duration-300 <?= strpos($_SERVER['REQUEST_URI'], 'category') !== false ? 'bg-white/40 shadow-sm' : '' ?>">
                <span class="material-symbols-outlined text-xl text-gray-700 group-hover:text-purple-600 transition-colors">category</span>
                <span class="font-medium text-gray-700 group-hover:text-gray-900 text-sm">Categories</span>
            </a>
            <a href="<?= BASE_URL ?>user" class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/30 transition-all duration-300 <?= strpos($_SERVER['REQUEST_URI'], 'user') !== false ? 'bg-white/40 shadow-sm' : '' ?>">
                <span class="material-symbols-outlined text-xl text-gray-700 group-hover:text-violet-600 transition-colors">group</span>
                <span class="font-medium text-gray-700 group-hover:text-gray-900 text-sm">Users</span>
            </a>
            <a href="<?= BASE_URL ?>return/verifications" class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/30 transition-all duration-300 <?= strpos($_SERVER['REQUEST_URI'], 'return/verifications') !== false ? 'bg-white/40 shadow-sm' : '' ?>">
                <span class="material-symbols-outlined text-xl text-gray-700 group-hover:text-amber-600 transition-colors">fact_check</span>
                <span class="font-medium text-gray-700 group-hover:text-gray-900 text-sm">Verifikasi Pengembalian</span>
            </a>
        <?php endif; ?>

        <?php if (getUserRole() === 'user'): ?>
            <a href="<?= BASE_URL ?>borrow" class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/30 transition-all duration-300 <?= strpos($_SERVER['REQUEST_URI'], 'borrow') !== false ? 'bg-white/40 shadow-sm' : '' ?>">
                <span class="material-symbols-outlined text-xl text-gray-700 group-hover:text-amber-600 transition-colors">shopping_bag</span>
                <span class="font-medium text-gray-700 group-hover:text-gray-900 text-sm">My Borrowings</span>
            </a>
            <a href="<?= BASE_URL ?>borrow/create" class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/30 transition-all duration-300">
                <span class="material-symbols-outlined text-xl text-gray-700 group-hover:text-emerald-600 transition-colors">add_circle</span>
                <span class="font-medium text-gray-700 group-hover:text-gray-900 text-sm">New Request</span>
            </a>
            <a href="<?= BASE_URL ?>settings" class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/30 transition-all duration-300 <?= strpos($_SERVER['REQUEST_URI'], 'settings') !== false ? 'bg-white/40 shadow-sm' : '' ?>">
                <span class="material-symbols-outlined text-xl text-gray-700 group-hover:text-violet-600 transition-colors">settings</span>
                <span class="font-medium text-gray-700 group-hover:text-gray-900 text-sm">Settings</span>
            </a>
        <?php endif; ?>

        <?php if (getUserRole() === 'kepala_lab'): ?>
            <?php
            // Get pending approvals count for badge
            $borrowingModel = new Borrowing();
            $pendingCount = $borrowingModel->getPendingCount();
            ?>
            <a href="<?= BASE_URL ?>approval" class="group flex items-center justify-between px-4 py-3 rounded-xl hover:bg-white/30 transition-all duration-300 <?= strpos($_SERVER['REQUEST_URI'], 'approval') !== false ? 'bg-white/40 shadow-sm' : '' ?>">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-xl text-gray-700 group-hover:text-emerald-600 transition-colors">check_circle</span>
                    <span class="font-medium text-gray-700 group-hover:text-gray-900 text-sm">Approvals</span>
                </div>
                <?php if ($pendingCount > 0): ?>
                    <span class="flex items-center justify-center min-w-[20px] h-5 px-1.5 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full shadow-lg animate-pulse">
                        <?= $pendingCount ?>
                    </span>
                <?php endif; ?>
            </a>
            <a href="<?= BASE_URL ?>borrow" class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/30 transition-all duration-300 <?= strpos($_SERVER['REQUEST_URI'], 'borrow') !== false ? 'bg-white/40 shadow-sm' : '' ?>">
                <span class="material-symbols-outlined text-xl text-gray-700 group-hover:text-amber-600 transition-colors">list_alt</span>
                <span class="font-medium text-gray-700 group-hover:text-gray-900 text-sm">All Borrowings</span>
            </a>
            <a href="<?= BASE_URL ?>report" class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/30 transition-all duration-300 <?= strpos($_SERVER['REQUEST_URI'], 'report') !== false ? 'bg-white/40 shadow-sm' : '' ?>">
                <span class="material-symbols-outlined text-xl text-gray-700 group-hover:text-violet-600 transition-colors">bar_chart</span>
                <span class="font-medium text-gray-700 group-hover:text-gray-900 text-sm">Reports</span>
            </a>
        <?php endif; ?>
    </nav>

    <!-- Logout -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/20">
        <a href="<?= BASE_URL ?>auth/logout" onclick="return confirm('Yakin ingin logout?')" class="group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50/50 transition-all duration-300">
            <span class="material-symbols-outlined text-xl text-gray-600 group-hover:text-red-600 transition-colors">logout</span>
            <span class="font-medium text-gray-700 group-hover:text-red-600 text-sm">Logout</span>
        </a>
    </div>
</aside>

<!-- Mobile Menu Button -->
<button onclick="toggleMobileMenu()" class="lg:hidden fixed top-6 left-6 z-50 w-11 h-11 glass-card rounded-xl flex items-center justify-center shadow-lg hover-lift">
    <span class="material-symbols-outlined text-gray-700">menu</span>
</button>

<!-- Overlay for mobile -->
<div onclick="toggleMobileMenu()" class="lg:hidden fixed inset-0 bg-black/20 backdrop-blur-sm z-40 hidden" id="sidebar-overlay"></div>

<script>
function toggleMobileMenu() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}
</script>
