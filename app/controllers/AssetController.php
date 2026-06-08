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
            'title' => 'Manajemen Asset',
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
                setFlash('success', 'Asset berhasil ditambahkan');
                $this->redirect('asset');
            } else {
                setFlash('danger', 'Gagal menambahkan asset');
            }
        }

        $data = [
            'title' => 'Tambah Asset',
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
                setFlash('success', 'Asset berhasil diupdate');
                $this->redirect('asset');
            } else {
                setFlash('danger', 'Gagal mengupdate asset');
            }
        }

        $data = [
            'title' => 'Edit Asset',
            'asset' => $this->assetModel->getById($id),
            'categories' => $this->categoryModel->getAll()
        ];

        $this->view('assets/edit', $data);
    }

    public function delete($id) {
        if ($this->assetModel->delete($id)) {
            setFlash('success', 'Asset berhasil dihapus');
        } else {
            setFlash('danger', 'Gagal menghapus asset');
        }
        $this->redirect('asset');
    }
}
