<!-- Minimal Topbar -->
<nav class="glass-card px-6 py-4 flex items-center justify-between mb-8 rounded-2xl relative z-40">
    <div>
        <h1 class="text-2xl font-semibold text-gray-900"><?= $title ?? 'Dashboard' ?></h1>
        <p class="text-sm text-gray-500 mt-0.5">Welcome back, manage your laboratory</p>
    </div>
    
    <div class="flex items-center gap-4">
        <?php 
        $loggedInRoles = getLoggedInRoles();
        $currentRole = getCurrentRole();
        ?>
        
        <!-- Role Switcher (if multiple roles logged in) -->
        <?php if (count($loggedInRoles) > 1): ?>
        <div class="relative z-50" id="roleSwitcher">
            <button onclick="toggleRoleSwitcher()" class="flex items-center gap-2 px-4 py-2 glass-card rounded-xl hover-lift">
                <span class="material-symbols-outlined text-emerald-600 text-lg">swap_horiz</span>
                <span class="text-sm font-medium text-gray-700">Switch Role</span>
                <span class="material-symbols-outlined text-gray-500 text-sm">expand_more</span>
            </button>
            
            <!-- Dropdown -->
            <div id="roleDropdown" class="hidden absolute right-0 mt-2 w-56 glass-card rounded-xl shadow-xl z-[100] overflow-hidden">
                <div class="px-4 py-3 border-b border-white/30">
                    <p class="text-xs text-gray-500 uppercase font-semibold">Active Roles</p>
                </div>
                <?php foreach ($loggedInRoles as $role): ?>
                    <?php
                    $roleLabels = [
                        'user' => 'Mahasiswa/Dosen',
                        'admin' => 'Admin',
                        'kepala_lab' => 'Kepala Lab'
                    ];
                    $roleIcons = [
                        'user' => 'person',
                        'admin' => 'admin_panel_settings',
                        'kepala_lab' => 'workspace_premium'
                    ];
                    $roleColors = [
                        'user' => 'text-blue-600',
                        'admin' => 'text-emerald-600',
                        'kepala_lab' => 'text-purple-600'
                    ];
                    $isActive = $role === $currentRole;
                    ?>
                    <a href="<?= BASE_URL ?>auth/switchRole/<?= $role ?>" 
                       class="flex items-center gap-3 px-4 py-3 hover:bg-white/30 transition-colors <?= $isActive ? 'bg-white/20' : '' ?>">
                        <span class="material-symbols-outlined <?= $roleColors[$role] ?> text-xl"><?= $roleIcons[$role] ?></span>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800"><?= $roleLabels[$role] ?></p>
                            <?php if ($isActive): ?>
                                <p class="text-xs text-emerald-600 font-semibold">● Active</p>
                            <?php endif; ?>
                        </div>
                        <?php if ($isActive): ?>
                            <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- User Avatar -->
        <div class="flex items-center gap-3 px-4 py-2 glass-card rounded-full hover-lift cursor-pointer">
            <div class="w-9 h-9 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center text-white font-semibold text-sm shadow-lg">
                <?= strtoupper(substr(getUserName(), 0, 1)) ?>
            </div>
            <div class="hidden sm:block">
                <p class="text-sm font-medium text-gray-900"><?= getUserName() ?></p>
                <p class="text-xs text-gray-500 capitalize"><?= str_replace('_', ' ', getUserRole()) ?></p>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleRoleSwitcher() {
    const dropdown = document.getElementById('roleDropdown');
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const switcher = document.getElementById('roleSwitcher');
    if (switcher && !switcher.contains(event.target)) {
        document.getElementById('roleDropdown').classList.add('hidden');
    }
});
</script>
