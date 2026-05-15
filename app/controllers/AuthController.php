<?php

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
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
            $data = [
                'name' => sanitize($_POST['name']),
                'nim_nip' => sanitize($_POST['nim_nip']),
                'email' => sanitize($_POST['email']),
                'username' => sanitize($_POST['username']),
                'password' => hashPassword($_POST['password']),
                'role' => 'user',
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->userModel->create($data)) {
                setFlash('success', 'Registrasi berhasil! Silakan login');
                $this->redirect('auth/login');
            } else {
                setFlash('danger', 'Registrasi gagal');
                $this->redirect('auth/register');
            }
        }

        $this->view('auth/register');
    }
}
