<?php

class ApprovalController extends Controller {
    private $borrowingModel;
    private $borrowDetailModel;
    private $assetModel;
    private $notificationModel;

    public function __construct() {
        $this->requireLogin();
        $this->checkRole(['kepala_lab', 'admin']);
        $this->borrowingModel = $this->model('Borrowing');
        $this->borrowDetailModel = $this->model('BorrowDetail');
        $this->assetModel = $this->model('Asset');
        $this->notificationModel = $this->model('Notification');
    }

    public function index() {
        $data = [
            'title' => 'Approval Peminjaman',
            'borrowings' => $this->borrowingModel->getByStatus('pending')
        ];

        $this->view('approvals/index', $data);
    }

    public function approve($id) {
        $borrowing = $this->borrowingModel->getById($id);
        
        if ($borrowing['status'] !== 'pending') {
            setFlash('danger', 'Peminjaman sudah diproses');
            $this->redirect('approval');
        }

        // Get borrow details
        $details = $this->borrowDetailModel->getByBorrowingId($id);
        
        // Check stock availability
        foreach ($details as $detail) {
            $asset = $this->assetModel->getById($detail['asset_id']);
            if ($asset['available_quantity'] < $detail['quantity']) {
                setFlash('danger', 'Stok tidak mencukupi untuk ' . $asset['name']);
                $this->redirect('approval');
            }
        }

        // Update stock
        foreach ($details as $detail) {
            $this->assetModel->updateStock($detail['asset_id'], $detail['quantity'], 'decrease');
        }

        // Update borrowing status
        $notes = isset($_POST['notes']) ? sanitize($_POST['notes']) : null;
        if ($this->borrowingModel->updateStatus($id, 'approved', $notes)) {
            // Create notification
            $notifData = [
                'user_id' => $borrowing['user_id'],
                'title' => 'Peminjaman Disetujui',
                'message' => 'Peminjaman dengan kode ' . $borrowing['borrow_code'] . ' telah disetujui',
                'type' => 'success',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->notificationModel->create($notifData);

            setFlash('success', 'Peminjaman berhasil disetujui');
        } else {
            setFlash('danger', 'Gagal menyetujui peminjaman');
        }

        $this->redirect('approval');
    }

    public function reject($id) {
        $borrowing = $this->borrowingModel->getById($id);
        
        if ($borrowing['status'] !== 'pending') {
            setFlash('danger', 'Peminjaman sudah diproses');
            $this->redirect('approval');
        }

        $notes = isset($_POST['notes']) ? sanitize($_POST['notes']) : null;
        if ($this->borrowingModel->updateStatus($id, 'rejected', $notes)) {
            // Create notification
            $notifData = [
                'user_id' => $borrowing['user_id'],
                'title' => 'Peminjaman Ditolak',
                'message' => 'Peminjaman dengan kode ' . $borrowing['borrow_code'] . ' ditolak. Alasan: ' . $notes,
                'type' => 'danger',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->notificationModel->create($notifData);

            setFlash('success', 'Peminjaman berhasil ditolak');
        } else {
            setFlash('danger', 'Gagal menolak peminjaman');
        }

        $this->redirect('approval');
    }
}
