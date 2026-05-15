<?php require_once '../app/views/layouts/header.php'; ?>

<div class="flex min-h-screen">
    <?php require_once '../app/views/layouts/sidebar.php'; ?>
    
    <!-- Main Content -->
    <main class="flex-1 lg:ml-64 p-8">
        <?php require_once '../app/views/layouts/navbar.php'; ?>

        <div class="space-y-6">
            <!-- Form Card -->
            <div class="glass-card rounded-3xl p-8">
                <form action="<?= BASE_URL ?>user/create" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input 
                                type="text" 
                                name="name" 
                                class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                required
                            />
                        </div>

                        <!-- NIM/NIP -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NIM / NIP *</label>
                            <input 
                                type="text" 
                                name="nim_nip" 
                                class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                required
                            />
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input 
                                type="email" 
                                name="email" 
                                class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                required
                            />
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                            <input 
                                type="text" 
                                name="username" 
                                class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                required
                            />
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                            <input 
                                type="password" 
                                name="password" 
                                class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                required
                            />
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                            <select 
                                name="role" 
                                class="w-full px-4 py-3 form-input rounded-xl focus:outline-none transition-all" 
                                required
                            >
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="kepala_lab">Kepala Lab</option>
                            </select>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-3 pt-4">
                        <button 
                            type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all font-medium flex items-center gap-2"
                        >
                            <span class="material-symbols-outlined text-lg">save</span>
                            Save User
                        </button>
                        <a 
                            href="<?= BASE_URL ?>user" 
                            class="px-6 py-3 glass-card rounded-xl hover-lift text-gray-700 font-medium flex items-center gap-2"
                        >
                            <span class="material-symbols-outlined text-lg">arrow_back</span>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
