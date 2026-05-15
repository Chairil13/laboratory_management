<?php require_once '../app/views/layouts/header.php'; ?>

<style>
    .auth-bg {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 50%, #dbeafe 100%);
        position: relative;
        overflow: hidden;
    }

    /* Animated floating blobs */
    .auth-bg::before {
        content: '';
        position: absolute;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, transparent 70%);
        top: -150px;
        right: -150px;
        border-radius: 50%;
        animation: floatBlob 8s ease-in-out infinite;
    }

    .auth-bg::after {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(56,189,248,0.12) 0%, transparent 70%);
        bottom: -100px;
        left: -100px;
        border-radius: 50%;
        animation: floatBlob 10s ease-in-out infinite reverse;
    }

    @keyframes floatBlob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -30px) scale(1.05); }
        66% { transform: translate(-20px, 20px) scale(0.95); }
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08), 
                    0 8px 16px rgba(0, 0, 0, 0.04),
                    inset 0 1px 0 rgba(255,255,255,0.9);
    }

    .auth-input {
        background: rgba(255, 255, 255, 0.7);
        border: 1.5px solid rgba(148, 163, 184, 0.3);
        color: #1e293b;
        transition: all 0.2s;
    }

    .auth-input::placeholder {
        color: rgba(100, 116, 139, 0.5);
    }

    .auth-input:focus {
        background: rgba(255, 255, 255, 0.95);
        border-color: rgba(16, 185, 129, 0.6);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        outline: none;
    }

    .auth-label {
        color: #475569;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .auth-icon {
        color: #64748b;
    }

    .btn-signin {
        background: linear-gradient(135deg, #10b981 0%, #0891b2 100%);
        color: #fff;
        font-weight: 600;
        border: none;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        transition: all 0.3s;
    }

    .btn-signin:hover {
        background: linear-gradient(135deg, #059669 0%, #0e7490 100%);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        transform: translateY(-1px);
    }

    .btn-signin:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    /* Grid dots decoration */
    .grid-dots {
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
    }

    /* Decorative shapes */
    .shape-1 {
        position: absolute;
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, rgba(16,185,129,0.08), rgba(56,189,248,0.08));
        border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        top: 10%;
        left: 5%;
        animation: morphShape 12s ease-in-out infinite;
        filter: blur(40px);
    }

    .shape-2 {
        position: absolute;
        width: 250px;
        height: 250px;
        background: linear-gradient(135deg, rgba(56,189,248,0.1), rgba(16,185,129,0.06));
        border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
        bottom: 15%;
        right: 8%;
        animation: morphShape 15s ease-in-out infinite reverse;
        filter: blur(40px);
    }

    @keyframes morphShape {
        0%, 100% { 
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            transform: rotate(0deg) scale(1);
        }
        50% { 
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            transform: rotate(180deg) scale(1.1);
        }
    }
</style>

<div class="auth-bg flex items-center justify-center p-6">
    <!-- Decorative shapes -->
    <div class="shape-1"></div>
    <div class="shape-2"></div>
    
    <!-- Grid dots overlay -->
    <div class="grid-dots"></div>

    <main class="auth-card relative z-10 w-full max-w-md rounded-2xl p-8 flex flex-col gap-7">
        
        <!-- Header -->
        <header class="flex flex-col items-center text-center gap-2">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-1 shadow-lg" style="background: linear-gradient(135deg, #10b981, #0891b2);">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1; font-size: 30px;">science</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Smart Lab MS</h1>
            <p class="text-sm text-gray-600">Sign in to manage laboratory assets and approvals.</p>
        </header>

        <!-- Flash Message -->
        <?php 
        $flash = getFlash();
        if ($flash): 
            $alertColors = [
                'success' => 'bg-emerald-500/20 border-emerald-400/40 text-gray-900',
                'danger'  => 'bg-red-500/20 border-red-400/40 text-gray-900',
                'warning' => 'bg-yellow-500/20 border-yellow-400/40 text-gray-900',
                'info'    => 'bg-sky-500/20 border-sky-400/40 text-gray-900'
            ];
            $colorClass = $alertColors[$flash['type']] ?? $alertColors['info'];
        ?>
            <div class="<?= $colorClass ?> border rounded-lg p-3 text-sm" data-alert>
                <?= $flash['message'] ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="<?= BASE_URL ?>auth/login" method="POST" class="flex flex-col gap-4">
            
            <!-- Username/Email Field -->
            <div class="flex flex-col gap-1.5">
                <label class="auth-label" for="username">Username / Email</label>
                <div class="relative">
                    <span class="material-symbols-outlined auth-icon absolute left-3 top-1/2 -translate-y-1/2 text-xl">person</span>
                    <input 
                        class="auth-input w-full rounded-lg py-2.5 pl-10 pr-3 text-base"
                        id="username" 
                        name="username" 
                        placeholder="admin or admin@lab.com" 
                        type="text"
                        required
                        autofocus
                    />
                </div>
            </div>

            <!-- Password Field -->
            <div class="flex flex-col gap-1.5">
                <div class="flex justify-between items-center">
                    <label class="auth-label" for="password">Password</label>
                    <a class="text-xs font-medium text-emerald-600 hover:text-emerald-700 transition-colors" href="#">
                        Forgot password?
                    </a>
                </div>
                <div class="relative">
                    <span class="material-symbols-outlined auth-icon absolute left-3 top-1/2 -translate-y-1/2 text-xl">lock</span>
                    <input 
                        class="auth-input w-full rounded-lg py-2.5 pl-10 pr-3 text-base"
                        id="password" 
                        name="password" 
                        placeholder="••••••••" 
                        type="password"
                        required
                    />
                </div>
            </div>

            <!-- Submit Button -->
            <button class="btn-signin mt-2 w-full py-3 rounded-xl flex items-center justify-center gap-2 text-base" type="submit">
                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">login</span>
                Sign In
            </button>

            <!-- Register Link -->
            <div class="text-center text-sm text-gray-600">
                Belum punya akun? 
                <a href="<?= BASE_URL ?>auth/register" class="font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                    Daftar di sini
                </a>
            </div>
        </form>

        <!-- Footer -->
        <footer class="text-center text-xs border-t pt-5 text-gray-500" style="border-color: rgba(148, 163, 184, 0.2);">
            <p>© 2024 Electrical Engineering Dept.</p>
            <p>Technical Laboratory System</p>
        </footer>
    </main>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
