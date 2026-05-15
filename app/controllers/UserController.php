<?php

class UserController extends Controller {
    private $userModel;

    public function __construct() {
        $this->checkRole(['admin']);
        $this->userModel = $this->model('User');
    }

    public function index() {
        $data = [
            'title' => 'Manajemen Pengguna',
            'users' => $this->userModel->getAll()
        ];

        $this->view('users/index', $data);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => sanitize($_POST['name']),
                'nim_nip' => sanitize($_POST['nim_nip']),
                'email' => sanitize($_POST['email']),
                'username' => sanitize($_POST['username']),
                'password' => hashPassword($_POST['password']),
                'role' => $_POST['role'],
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->userModel->create($data)) {
                setFlash('success', 'Pengguna berhasil ditambahkan');
                $this->redirect('user');
            } else {
                setFlash('danger', 'Gagal menambahkan pengguna');
            }
        }

        $data = ['title' => 'Tambah Pengguna'];
        $this->view('users/create', $data);
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => sanitize($_POST['name']),
                'nim_nip' => sanitize($_POST['nim_nip']),
                'email' => sanitize($_POST['email']),
                'username' => sanitize($_POST['username']),
                'role' => $_POST['role'],
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!empty($_POST['password'])) {
                $data['password'] = hashPassword($_POST['password']);
            }

            if ($this->userModel->update($id, $data)) {
                setFlash('success', 'Pengguna berhasil diupdate');
                $this->redirect('user');
            } else {
                setFlash('danger', 'Gagal mengupdate pengguna');
            }
        }

        $data = [
            'title' => 'Edit Pengguna',
            'user' => $this->userModel->getById($id)
        ];

        $this->view('users/edit', $data);
    }

    public function delete($id) {
        if ($id == getUserId()) {
            setFlash('danger', 'Tidak dapat menghapus akun sendiri');
            $this->redirect('user');
        }

        if ($this->userModel->delete($id)) {
            setFlash('success', 'Pengguna berhasil dihapus');
        } else {
            setFlash('danger', 'Gagal menghapus pengguna');
        }
        $this->redirect('user');
    }
}
