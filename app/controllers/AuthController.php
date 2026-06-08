<?php

class AuthController extends Controller {
    private $userModel;
    private $registrationRequestModel;

    public function __construct() {
        $this->userModel = $this->model('User');
        $this->registrationRequestModel = $this->model('RegistrationRequest');
    }

    public function login() {
        // Don't redirect if accessing login page directly
        // Allow multiple role logins
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = sanitize($_POST['username']);
            $password = $_POST['password'];

            if (empty($username) || empty($password)) {
                setFlash('danger', 'Username dan password harus diisi');
                $this->redirect('auth/login');
            }

            $user = $this->userModel->authenticate($username, $password);

            if ($user) {
                // Check if this role is already logged in
                if (isRoleLoggedIn($user['role'])) {
                    // Switch to that role instead of creating new session
                    switchRole($user['role']);
                    setFlash('info', 'Anda sudah login sebagai ' . $user['role'] . '. Beralih ke role tersebut.');
                    $this->redirect('dashboard');
                } else {
                    // Set role-specific session
                    setRoleSession($user['role'], $user);
                    $this->userModel->updateLastLogin($user['id']);
                    setFlash('success', 'Login berhasil! Selamat datang ' . $user['name']);
                    $this->redirect('dashboard');
                }
            } else {
                setFlash('danger', 'Username atau password salah');
                $this->redirect('auth/login');
            }
        }

        $this->view('auth/login');
    }

    public function logout() {
        $role = getCurrentRole();
        if ($role) {
            clearRoleSession($role);
        }
        
        // Check if there are other logged in roles
        $loggedInRoles = getLoggedInRoles();
        if (!empty($loggedInRoles)) {
            // Switch to first available role
            switchRole($loggedInRoles[0]);
            setFlash('success', 'Anda telah logout dari ' . $role);
            $this->redirect('dashboard');
        } else {
            // No other roles logged in, destroy session
            session_destroy();
            setFlash('success', 'Anda telah logout');
            $this->redirect('auth/login');
        }
    }

    public function switchRole($role) {
        if (!isRoleLoggedIn($role)) {
            setFlash('danger', 'Role tidak ditemukan atau belum login');
            $this->redirect('dashboard');
        }

        if (switchRole($role)) {
            setFlash('success', 'Berhasil beralih ke role ' . $role);
        } else {
            setFlash('danger', 'Gagal beralih role');
        }

        $this->redirect('dashboard');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = sanitize($_POST['name']);
            $applicantType = sanitize($_POST['applicant_type'] ?? 'mahasiswa');
            $nim = sanitize($_POST['nim']);
            $email = sanitize($_POST['email']);
            $phone = sanitize($_POST['phone'] ?? '');
            $programStudi = sanitize($_POST['program_studi']);
            $semester = sanitize($_POST['semester'] ?? '');
            $className = sanitize($_POST['class_name'] ?? '');
            $reason = sanitize($_POST['reason'] ?? '');

            if (!in_array($applicantType, ['mahasiswa', 'dosen'])) {
                setFlash('danger', 'Jenis pemohon tidak valid');
                $this->redirect('auth/register');
            }

            if (empty($name) || empty($nim) || empty($email) || empty($programStudi)) {
                setFlash('danger', 'Nama, NIM/NIP, email, dan program studi wajib diisi');
                $this->redirect('auth/register');
            }

            if (!validateEmail($email)) {
                setFlash('danger', 'Format email tidak valid');
                $this->redirect('auth/register');
            }

            $allowedPrograms = [
                'Teknik Listrik D3',
                'Teknik Informatika D4',
                'Teknologi Rekayasa Sistem Kelistrikan Minyak dan Gas D4'
            ];

            if (!in_array($programStudi, $allowedPrograms)) {
                setFlash('danger', 'Pengajuan hanya dibuka untuk mahasiswa dan dosen Jurusan Teknik Elektro.');
                $this->redirect('auth/register');
            }

            if ($this->userModel->findByNimNip($nim) || $this->userModel->findByEmail($email)) {
                setFlash('danger', 'NIM atau email sudah terdaftar sebagai akun aktif. Silakan hubungi admin laboratorium.');
                $this->redirect('auth/register');
            }

            if ($this->registrationRequestModel->existsActive($nim, $email)) {
                setFlash('warning', 'Pengajuan dengan NIM atau email tersebut masih menunggu verifikasi admin.');
                $this->redirect('auth/register');
            }

            $data = [
                'applicant_type' => $applicantType,
                'name' => $name,
                'nim' => $nim,
                'email' => $email,
                'phone' => $phone,
                'program_studi' => $programStudi,
                'semester' => $semester,
                'class_name' => $className,
                'reason' => $reason,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->registrationRequestModel->create($data)) {
                setFlash('success', 'Pengajuan akun berhasil dikirim. Admin akan memverifikasi data Anda sebelum akun dapat digunakan.');
                $this->redirect('auth/login');
            } else {
                setFlash('danger', 'Pengajuan akun gagal dikirim');
                $this->redirect('auth/register');
            }
        }

        $this->view('auth/register');
    }
}
