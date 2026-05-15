<?php require_once '../app/views/layouts/header.php'; ?>

<div class="flex min-h-screen">
    <?php require_once '../app/views/layouts/sidebar.php'; ?>
    
    <main class="flex-1 lg:ml-64 p-8">
        <?php require_once '../app/views/layouts/navbar.php'; ?>

        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Flash Message -->
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
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center shadow-xl">
                    <span class="material-symbols-outlined text-white text-3xl">settings</span>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Settings</h1>
                    <p class="text-gray-600 mt-1">Manage your account settings and preferences</p>
                </div>
            </div>

            <!-- Profile Information Card -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-slate-50">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-gray-700">person</span>
                        Profile Information
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Your personal information (read-only)</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-xl border border-gray-200">
                                <span class="material-symbols-outlined text-gray-400">badge</span>
                                <span class="text-gray-800"><?= htmlspecialchars($user['name']) ?></span>
                            </div>
                        </div>

                        <!-- NIM/NIP -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">NIM/NIP</label>
                            <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-xl border border-gray-200">
                                <span class="material-symbols-outlined text-gray-400">badge</span>
                                <span class="text-gray-800"><?= htmlspecialchars($user['nim_nip']) ?></span>
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-xl border border-gray-200">
                                <span class="material-symbols-outlined text-gray-400">email</span>
                                <span class="text-gray-800"><?= htmlspecialchars($user['email']) ?></span>
                            </div>
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                            <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-xl border border-gray-200">
                                <span class="material-symbols-outlined text-gray-400">account_circle</span>
                                <span class="text-gray-800"><?= htmlspecialchars($user['username']) ?></span>
                            </div>
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                            <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-xl border border-gray-200">
                                <span class="material-symbols-outlined text-gray-400">shield</span>
                                <span class="text-gray-800 capitalize"><?= str_replace('_', ' ', htmlspecialchars($user['role'])) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-emerald-100">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600">lock</span>
                        Change Password
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Update your password to keep your account secure</p>
                </div>
                <div class="p-6">
                    <form action="<?= BASE_URL ?>settings/changePassword" method="POST" class="space-y-5">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Current Password
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">lock</span>
                                <input 
                                    type="password" 
                                    id="current_password" 
                                    name="current_password" 
                                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                    placeholder="Enter your current password"
                                    required
                                />
                            </div>
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                New Password
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">lock_open</span>
                                <input 
                                    type="password" 
                                    id="new_password" 
                                    name="new_password" 
                                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                    placeholder="Enter new password (min. 6 characters)"
                                    minlength="6"
                                    required
                                />
                            </div>
                            <p class="text-xs text-gray-500 mt-1 ml-1">Password must be at least 6 characters long</p>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="confirm_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirm New Password
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">lock_open</span>
                                <input 
                                    type="password" 
                                    id="confirm_password" 
                                    name="confirm_password" 
                                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                    placeholder="Confirm your new password"
                                    minlength="6"
                                    required
                                />
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center gap-3 pt-4">
                            <button 
                                type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all flex items-center gap-2"
                            >
                                <span class="material-symbols-outlined text-lg">check_circle</span>
                                Update Password
                            </button>
                            <a 
                                href="<?= BASE_URL ?>dashboard" 
                                class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all flex items-center gap-2"
                            >
                                <span class="material-symbols-outlined text-lg">cancel</span>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Tips -->
            <div class="glass-card rounded-2xl p-6 bg-gradient-to-r from-blue-50 to-cyan-50 border border-blue-200">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-blue-600 text-2xl">info</span>
                    <div>
                        <h3 class="font-semibold text-blue-900 mb-2">Security Tips</h3>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Use a strong password with a mix of letters, numbers, and symbols</li>
                            <li>• Don't share your password with anyone</li>
                            <li>• Change your password regularly</li>
                            <li>• Don't use the same password for multiple accounts</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
// Auto-hide flash messages after 5 seconds
setTimeout(() => {
    const alert = document.querySelector('[data-alert]');
    if (alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    }
}, 5000);

// Password confirmation validation
document.querySelector('form').addEventListener('submit', function(e) {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (newPassword !== confirmPassword) {
        e.preventDefault();
        alert('Password baru dan konfirmasi password tidak cocok!');
    }
});
</script>

<?php require_once '../app/views/layouts/footer.php'; ?>
