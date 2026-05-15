<?php

class CategoryController extends Controller {
    private $categoryModel;

    public function __construct() {
        $this->requireLogin();
        $this->checkRole(['admin']);
        $this->categoryModel = $this->model('Category');
    }

    public function index() {
        $data = [
            'title' => 'Kelola Kategori',
            'categories' => $this->categoryModel->getWithAssetCount()
        ];

        $this->view('categories/index', $data);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => sanitize($_POST['name']),
                'description' => sanitize($_POST['description']),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->categoryModel->create($data)) {
                setFlash('success', 'Kategori berhasil ditambahkan');
                $this->redirect('category');
            } else {
                setFlash('danger', 'Gagal menambahkan kategori');
                $this->redirect('category');
            }
        }

        $data = [
            'title' => 'Tambah Kategori'
        ];

        $this->view('categories/create', $data);
    }

    public function edit($id) {
        $category = $this->categoryModel->getById($id);

        if (!$category) {
            setFlash('danger', 'Kategori tidak ditemukan');
            $this->redirect('category');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => sanitize($_POST['name']),
                'description' => sanitize($_POST['description']),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->categoryModel->update($id, $data)) {
                setFlash('success', 'Kategori berhasil diupdate');
                $this->redirect('category');
            } else {
                setFlash('danger', 'Gagal mengupdate kategori');
                $this->redirect('category');
            }
        }

        $data = [
            'title' => 'Edit Kategori',
            'category' => $category
        ];

        $this->view('categories/edit', $data);
    }

    public function delete($id) {
        $category = $this->categoryModel->getById($id);

        if (!$category) {
            setFlash('danger', 'Kategori tidak ditemukan');
            $this->redirect('category');
        }

        if ($this->categoryModel->delete($id)) {
            setFlash('success', 'Kategori berhasil dihapus');
        } else {
            setFlash('danger', 'Gagal menghapus kategori');
        }

        $this->redirect('category');
    }
}
