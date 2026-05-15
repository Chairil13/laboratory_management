<?php

class AssetController extends Controller {
    private $assetModel;
    private $categoryModel;

    public function __construct() {
        $this->checkRole(['admin']);
        $this->assetModel = $this->model('Asset');
        $this->categoryModel = $this->model('Category');
    }

    public function index() {
        $data = [
            'title' => 'Manajemen Aset',
            'assets' => $this->assetModel->getAllWithCategory()
        ];

        $this->view('assets/index', $data);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'code' => sanitize($_POST['code']),
                'name' => sanitize($_POST['name']),
                'category_id' => $_POST['category_id'],
                'total_quantity' => $_POST['total_quantity'],
                'available_quantity' => $_POST['total_quantity'],
                'location' => sanitize($_POST['location']),
                'condition' => $_POST['condition'],
                'description' => sanitize($_POST['description']),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->assetModel->create($data)) {
                setFlash('success', 'Aset berhasil ditambahkan');
                $this->redirect('asset');
            } else {
                setFlash('danger', 'Gagal menambahkan aset');
            }
        }

        $data = [
            'title' => 'Tambah Aset',
            'categories' => $this->categoryModel->getAll()
        ];

        $this->view('assets/create', $data);
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $asset = $this->assetModel->getById($id);
            $quantityDiff = $_POST['total_quantity'] - $asset['total_quantity'];
            
            $data = [
                'code' => sanitize($_POST['code']),
                'name' => sanitize($_POST['name']),
                'category_id' => $_POST['category_id'],
                'total_quantity' => $_POST['total_quantity'],
                'available_quantity' => $asset['available_quantity'] + $quantityDiff,
                'location' => sanitize($_POST['location']),
                'condition' => $_POST['condition'],
                'description' => sanitize($_POST['description']),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->assetModel->update($id, $data)) {
                setFlash('success', 'Aset berhasil diupdate');
                $this->redirect('asset');
            } else {
                setFlash('danger', 'Gagal mengupdate aset');
            }
        }

        $data = [
            'title' => 'Edit Aset',
            'asset' => $this->assetModel->getById($id),
            'categories' => $this->categoryModel->getAll()
        ];

        $this->view('assets/edit', $data);
    }

    public function delete($id) {
        if ($this->assetModel->delete($id)) {
            setFlash('success', 'Aset berhasil dihapus');
        } else {
            setFlash('danger', 'Gagal menghapus aset');
        }
        $this->redirect('asset');
    }
}
