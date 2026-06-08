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

    .toggle-password {
        color: #94a3b8;
        cursor: pointer;
        transition: color 0.2s;
        user-select: none;
        background: none;
        border: none;
        padding: 0;
        line-height: 1;
    }

    .toggle-password:hover {
        color: #10b981;
    }

    .btn-register {
        background: linear-gradient(135deg, #10b981 0%, #0891b2 100%);
        color: #fff;
        font-weight: 600;
        border: none;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        transition: all 0.3s;
    }

    .btn-register:hover {
        background: linear-gradient(135deg, #059669 0%, #0e7490 100%);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        transform: translateY(-1px);
    }

    .btn-register:active {
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

    .auth-bg {
        background:
            radial-gradient(circle at 18px 18px, rgba(59, 36, 23, 0.08) 1.5px, transparent 1.5px),
            linear-gradient(90deg, rgba(159, 47, 40, 0.08), transparent 30%, rgba(31, 107, 92, 0.1)),
            #f3e6cf;
        background-size: 24px 24px, auto, auto;
    }

    .auth-bg::before,
    .auth-bg::after,
    .shape-1,
    .shape-2 {
        display: none;
    }

    .auth-card {
        background: #fff6df;
        border: 2px solid #3b2417;
        border-radius: 8px;
        box-shadow: 10px 10px 0 rgba(59, 36, 23, 0.24);
    }

    .auth-card h1 {
        font-family: Georgia, 'Times New Roman', serif;
        color: #3b2417;
        font-size: 2.2rem;
    }

    .auth-card header > div {
        background: #9f2f28 !important;
        border: 2px solid #3b2417;
        border-radius: 8px;
        box-shadow: 5px 5px 0 rgba(59, 36, 23, 0.22);
    }

    .auth-input {
        background: rgba(255, 246, 223, 0.88);
        border: 2px solid rgba(59, 36, 23, 0.35);
        color: #24180f;
        border-radius: 8px;
    }

    .auth-input:focus {
        border-color: #9f2f28;
        box-shadow: 0 0 0 3px rgba(159, 47, 40, 0.14);
    }

    .auth-label {
        color: #3b2417;
        font-family: Inter, sans-serif;
    }

    .btn-register {
        background: #9f2f28;
        border: 2px solid #3b2417;
        border-radius: 8px;
        box-shadow: 5px 5px 0 #3b2417;
    }

    .btn-register:hover {
        background: #7f251f;
        box-shadow: 5px 5px 0 #3b2417;
    }

    .grid-dots {
        background-image: radial-gradient(rgba(59, 36, 23, 0.12) 1px, transparent 1px);
        background-size: 24px 24px;
    }
</style>

<div class="auth-bg flex items-center justify-center p-6">
    <!-- Decorative shapes -->
    <div class="shape-1"></div>
    <div class="shape-2"></div>
    
    <!-- Grid dots overlay -->
    <div class="grid-dots"></div>

    <main class="auth-card relative z-10 w-full max-w-2xl rounded-2xl p-8 flex flex-col gap-6">
        
        <!-- Header -->
        <header class="flex flex-col items-center text-center gap-2">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-1 shadow-lg" style="background: linear-gradient(135deg, #10b981, #0891b2);">
                <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1; font-size: 30px;">person_add</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Pengajuan Akun Civitas Elektro</h1>
            <p class="text-sm text-gray-600">Akun hanya dibuat setelah diverifikasi admin laboratorium.</p>
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

        <!-- Request Form -->
        <form action="<?= BASE_URL ?>auth/register" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            
            <!-- Nama Lengkap -->
            <div class="flex flex-col gap-1.5 md:col-span-2">
                <label class="auth-label" for="name">Nama Lengkap</label>
                <input 
                    class="auth-input w-full rounded-lg py-2.5 px-3 text-base"
                    id="name" 
                    name="name" 
                    placeholder="" 
                    type="text"
                    required
                />
            </div>

            <!-- Applicant Type -->
            <div class="flex flex-col gap-1.5">
                <label class="auth-label" for="applicant_type">Jenis Pemohon</label>
                <select
                    class="auth-input w-full rounded-lg py-2.5 px-3 text-base"
                    id="applicant_type"
                    name="applicant_type"
                    required
                >
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                </select>
            </div>

            <!-- NIM -->
            <div class="flex flex-col gap-1.5">
                <label class="auth-label" for="nim">NIM / NIP</label>
                <input 
                    class="auth-input w-full rounded-lg py-2.5 px-3 text-base"
                    id="nim" 
                    name="nim" 
                    placeholder="" 
                    type="text"
                    required
                />
            </div>

            <!-- Email -->
            <div class="flex flex-col gap-1.5">
                <label class="auth-label" for="email">Email</label>
                <input 
                    class="auth-input w-full rounded-lg py-2.5 px-3 text-base"
                    id="email" 
                    name="email" 
                    placeholder="" 
                    type="email"
                    required
                />
            </div>

            <!-- Phone -->
            <div class="flex flex-col gap-1.5 md:col-span-2">
                <label class="auth-label" for="phone">No. HP / WhatsApp</label>
                <input 
                    class="auth-input w-full rounded-lg py-2.5 px-3 text-base"
                    id="phone" 
                    name="phone" 
                    placeholder="" 
                    type="text"
                />
            </div>

            <!-- Program Studi -->
            <div class="flex flex-col gap-1.5">
                <label class="auth-label" for="program_studi">Program Studi Elektro</label>
                <select
                    class="auth-input w-full rounded-lg py-2.5 px-3 text-base"
                    id="program_studi"
                    name="program_studi"
                    required
                >
                    <option value="">Pilih program studi</option>
                    <option value="Teknik Listrik D3">Teknik Listrik D3</option>
                    <option value="Teknik Informatika D4">Teknik Informatika D4</option>
                    <option value="Teknologi Rekayasa Sistem Kelistrikan Minyak dan Gas D4">Teknologi Rekayasa Sistem Kelistrikan Minyak dan Gas D4</option>
                </select>
            </div>

            <!-- Semester -->
            <div class="flex flex-col gap-1.5">
                <label class="auth-label" for="semester">Semester</label>
                <select
                    class="auth-input w-full rounded-lg py-2.5 px-3 text-base"
                    id="semester"
                    name="semester"
                >
                    <option value="">Pilih semester</option>
                    <?php for ($i = 1; $i <= 8; $i++): ?>
                        <option value="<?= $i ?>">Semester <?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <p class="text-xs text-gray-500 mt-1">Khusus mahasiswa. Dosen boleh mengosongkan bagian ini.</p>
            </div>

            <!-- Class -->
            <div class="flex flex-col gap-1.5 md:col-span-2">
                <label class="auth-label" for="class_name">Kelas</label>
                <input 
                    class="auth-input w-full rounded-lg py-2.5 px-3 text-base"
                    id="class_name" 
                    name="class_name" 
                    placeholder="Contoh mahasiswa: TL-2A. Dosen boleh dikosongkan." 
                    type="text"
                />
                <p class="text-xs text-gray-500 mt-1">Khusus mahasiswa. Dosen boleh mengosongkan bagian ini.</p>
            </div>

            <!-- Reason -->
            <div class="flex flex-col gap-1.5 md:col-span-2">
                <label class="auth-label" for="reason">Keperluan Akses</label>
                <textarea
                    class="auth-input w-full rounded-lg py-2.5 px-3 text-base"
                    id="reason"
                    name="reason"
                    rows="3"
                    placeholder="Contoh: membutuhkan akses untuk peminjaman alat praktikum atau kegiatan perkuliahan"
                ></textarea>
            </div>

            <!-- Submit Button -->
            <div class="md:col-span-2">
                <button class="btn-register w-full py-3 rounded-xl flex items-center justify-center gap-2 text-base" type="submit">
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">outgoing_mail</span>
                    Kirim Pengajuan
                </button>
            </div>

            <!-- Login Link -->
            <div class="md:col-span-2 text-center text-sm text-gray-600">
                Sudah diverifikasi admin dan punya akun? 
                <a href="<?= BASE_URL ?>auth/login" class="font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                    Masuk di sini
                </a>
            </div>
        </form>

        <!-- Footer -->
        <footer class="text-center text-xs border-t pt-5 text-gray-500" style="border-color: rgba(148, 163, 184, 0.2);">
            <p>© 2026 Electrical Engineering Dept.</p>
            <p>Technical Laboratory System</p>
        </footer>
    </main>
</div>

<script>
function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const icon = btn.querySelector('.material-symbols-outlined');
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility_off';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility';
    }
}
</script>

<?php require_once '../app/views/layouts/footer.php'; ?>



