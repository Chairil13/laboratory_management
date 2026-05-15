<?php

class SettingsController extends Controller {
    private $userModel;

    public function __construct() {
        $this->requireLogin();
        $this->userModel = $this->model('User');
    }

    public function index() {
        $user = $this->userModel->getById(getUserId());

        if (!$user) {
            setFlash('danger', 'User tidak ditemukan');
            $this->redirect('dashboard');
        }

        $data = [
            'title' => 'Settings',
            'user' => $user
        ];

        $this->view('settings/index', $data);
    }

    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            // Validation
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                setFlash('danger', 'Semua field harus diisi');
                $this->redirect('settings');
                return;
            }

            if ($newPassword !== $confirmPassword) {
                setFlash('danger', 'Password baru dan konfirmasi password tidak cocok');
                $this->redirect('settings');
                return;
            }

            if (strlen($newPassword) < 6) {
                setFlash('danger', 'Password baru minimal 6 karakter');
                $this->redirect('settings');
                return;
            }

            // Get user data
            $user = $this->userModel->getById(getUserId());

            // Verify current password
            if (!verifyPassword($currentPassword, $user['password'])) {
                setFlash('danger', 'Password saat ini salah');
                $this->redirect('settings');
                return;
            }

            // Update password
            $hashedPassword = hashPassword($newPassword);
            $updateData = [
                'password' => $hashedPassword,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->userModel->update(getUserId(), $updateData)) {
                // Get current role before logout
                $role = getCurrentRole();
                
                // Clear session for current role
                if ($role) {
                    clearRoleSession($role);
                }
                
                // Check if there are other logged in roles
                $loggedInRoles = getLoggedInRoles();
                if (empty($loggedInRoles)) {
                    // No other roles logged in, destroy session completely
                    session_destroy();
                    
                    // Start new session for flash message
                    session_start();
                }
                
                // Set flash message AFTER session is ready
                setFlash('success', 'Password berhasil diubah. Silakan login kembali dengan password baru Anda.');
                
                // Redirect to login
                $this->redirect('auth/login');
            } else {
                setFlash('danger', 'Gagal mengubah password');
                $this->redirect('settings');
            }
        }
    }
}
