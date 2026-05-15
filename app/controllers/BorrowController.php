<?php

class BorrowController extends Controller {
    private $borrowingModel;
    private $assetModel;
    private $borrowDetailModel;
    private $notificationModel;

    public function __construct() {
        $this->requireLogin();
        $this->borrowingModel = $this->model('Borrowing');
        $this->assetModel = $this->model('Asset');
        $this->borrowDetailModel = $this->model('BorrowDetail');
        $this->notificationModel = $this->model('Notification');
    }

    public function index() {
        if (getUserRole() === 'user') {
            $borrowings = $this->borrowingModel->getByUserId(getUserId());
        } else {
            $borrowings = $this->borrowingModel->getAllWithDetails();
        }

        $data = [
            'title' => 'Daftar Peminjaman',
            'borrowings' => $borrowings
        ];

        $this->view('borrowings/index', $data);
    }

    public function create() {
        $this->checkRole(['user']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $borrowCode = 'BRW-' . date('Ymd') . '-' . rand(1000, 9999);
            
            $borrowData = [
                'borrow_code' => $borrowCode,
                'user_id' => getUserId(),
                'borrow_date' => $_POST['borrow_date'],
                'return_date' => $_POST['return_date'],
                'purpose' => sanitize($_POST['purpose']),
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->borrowingModel->create($borrowData)) {
                $borrowingId = $this->borrowingModel->lastInsertId();
                
                // Create borrow details
                $assetIds = $_POST['asset_id'];
                $quantities = $_POST['quantity'];
                
                for ($i = 0; $i < count($assetIds); $i++) {
                    $detailData = [
                        'borrowing_id' => $borrowingId,
                        'asset_id' => $assetIds[$i],
                        'quantity' => $quantities[$i]
                    ];
                    $this->borrowDetailModel->create($detailData);
                }

                setFlash('success', 'Pengajuan peminjaman berhasil dibuat');
                $this->redirect('borrow');
            } else {
                setFlash('danger', 'Gagal membuat pengajuan');
            }
        }

        $data = [
            'title' => 'Ajukan Peminjaman',
            'assets' => $this->assetModel->getAvailableAssets()
        ];

        $this->view('borrowings/create', $data);
    }

    public function detail($id) {
        $data = [
            'title' => 'Detail Peminjaman',
            'borrowing' => $this->borrowingModel->getById($id),
            'details' => $this->borrowDetailModel->getByBorrowingId($id)
        ];

        $this->view('borrowings/detail', $data);
    }

    public function cancel($id) {
        $borrowing = $this->borrowingModel->getById($id);
        
        if ($borrowing['user_id'] != getUserId() || $borrowing['status'] != 'pending') {
            setFlash('danger', 'Tidak dapat membatalkan peminjaman ini');
            $this->redirect('borrow');
        }

        if ($this->borrowingModel->updateStatus($id, 'cancelled')) {
            setFlash('success', 'Peminjaman berhasil dibatalkan');
        } else {
            setFlash('danger', 'Gagal membatalkan peminjaman');
        }
        
        $this->redirect('borrow');
    }
}
