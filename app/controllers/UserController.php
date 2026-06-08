<?php

class UserController extends Controller {
    private $userModel;
    private $registrationRequestModel;

    public function __construct() {
        $this->checkRole(['admin']);
        $this->userModel = $this->model('User');
        $this->registrationRequestModel = $this->model('RegistrationRequest');
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

    public function applications() {
        $data = [
            'title' => 'Pengajuan Akun',
            'requests' => $this->registrationRequestModel->getAllWithReviewer()
        ];

        $this->view('users/applications', $data);
    }

    public function editApplication($id) {
        $request = $this->registrationRequestModel->getById($id);

        if (!$request) {
            setFlash('danger', 'Pengajuan akun tidak ditemukan');
            $this->redirect('user/applications');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $applicantType = sanitize($_POST['applicant_type'] ?? 'mahasiswa');
            $programStudi = sanitize($_POST['program_studi']);
            $allowedPrograms = [
                'Teknik Listrik D3',
                'Teknik Informatika D4',
                'Teknologi Rekayasa Sistem Kelistrikan Minyak dan Gas D4'
            ];

            if (!in_array($applicantType, ['mahasiswa', 'dosen'])) {
                setFlash('danger', 'Jenis pemohon tidak valid');
                $this->redirect('user/editApplication/' . $id);
            }

            if (!in_array($programStudi, $allowedPrograms)) {
                setFlash('danger', 'Program studi harus berasal dari Jurusan Teknik Elektro');
                $this->redirect('user/editApplication/' . $id);
            }

            $data = [
                'name' => sanitize($_POST['name']),
                'applicant_type' => $applicantType,
                'nim' => sanitize($_POST['nim']),
                'email' => sanitize($_POST['email']),
                'phone' => sanitize($_POST['phone'] ?? ''),
                'program_studi' => $programStudi,
                'semester' => sanitize($_POST['semester'] ?? ''),
                'class_name' => sanitize($_POST['class_name'] ?? ''),
                'reason' => sanitize($_POST['reason'] ?? ''),
                'admin_notes' => sanitize($_POST['admin_notes'] ?? '')
            ];

            if (empty($data['name']) || empty($data['nim']) || empty($data['email']) || empty($data['program_studi'])) {
                setFlash('danger', 'Nama, NIM/NIP, email, dan program studi wajib diisi');
                $this->redirect('user/editApplication/' . $id);
            }

            if (!validateEmail($data['email'])) {
                setFlash('danger', 'Format email tidak valid');
                $this->redirect('user/editApplication/' . $id);
            }

            if ($this->registrationRequestModel->update($id, $data)) {
                setFlash('success', 'Data pengajuan berhasil diperbarui');
                $this->redirect('user/applications');
            } else {
                setFlash('danger', 'Gagal memperbarui data pengajuan');
            }
        }

        $data = [
            'title' => 'Edit Pengajuan Akun',
            'request' => $request
        ];

        $this->view('users/application_edit', $data);
    }

    public function approveApplication($id) {
        $request = $this->registrationRequestModel->getById($id);

        if (!$request || $request['status'] !== 'pending') {
            setFlash('danger', 'Pengajuan tidak ditemukan atau sudah diproses');
            $this->redirect('user/applications');
        }

        if ($this->userModel->findByNimNip($request['nim']) || $this->userModel->findByEmail($request['email'])) {
            setFlash('danger', 'NIM atau email sudah digunakan oleh akun aktif');
            $this->redirect('user/applications');
        }

        $username = strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $request['nim']));
        if ($this->userModel->findByUsername($username)) {
            $username = $username . '_' . $request['id'];
        }

        $temporaryPassword = $request['nim'];
        $userData = [
            'name' => $request['name'],
            'nim_nip' => $request['nim'],
            'email' => $request['email'],
            'username' => $username,
            'password' => hashPassword($temporaryPassword),
            'role' => 'user',
            'created_at' => date('Y-m-d H:i:s')
        ];

        if (!$this->userModel->create($userData)) {
            setFlash('danger', 'Gagal membuat akun dari pengajuan');
            $this->redirect('user/applications');
        }

        $createdUserId = $this->userModel->lastInsertId();
        $notes = sanitize($_POST['admin_notes'] ?? '');
        $this->registrationRequestModel->approve($id, getUserId(), $createdUserId, $notes);

        setFlash('success', 'Pengajuan disetujui. Akun dibuat dengan username: ' . $username . ' dan password awal: NIM/NIP pemohon.');
        $this->redirect('user/applications');
    }

    public function rejectApplication($id) {
        $request = $this->registrationRequestModel->getById($id);

        if (!$request || $request['status'] !== 'pending') {
            setFlash('danger', 'Pengajuan tidak ditemukan atau sudah diproses');
            $this->redirect('user/applications');
        }

        $notes = sanitize($_POST['admin_notes'] ?? '');
        $this->registrationRequestModel->reject($id, getUserId(), $notes);

        setFlash('success', 'Pengajuan akun ditolak');
        $this->redirect('user/applications');
    }

    public function deleteApplication($id) {
        $request = $this->registrationRequestModel->getById($id);

        if (!$request) {
            setFlash('danger', 'Pengajuan akun tidak ditemukan');
            $this->redirect('user/applications');
        }

        if ($this->registrationRequestModel->delete($id)) {
            setFlash('success', 'Pengajuan akun berhasil dihapus');
        } else {
            setFlash('danger', 'Gagal menghapus pengajuan akun');
        }

        $this->redirect('user/applications');
    }
}
