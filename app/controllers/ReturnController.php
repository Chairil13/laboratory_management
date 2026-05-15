<?php

class ReturnController extends Controller {
    private $returnModel;
    private $borrowingModel;
    private $borrowDetailModel;
    private $assetModel;
    private $notificationModel;

    public function __construct() {
        $this->requireLogin();
        $this->returnModel = $this->model('ReturnModel');
        $this->borrowingModel = $this->model('Borrowing');
        $this->borrowDetailModel = $this->model('BorrowDetail');
        $this->assetModel = $this->model('Asset');
        $this->notificationModel = $this->model('Notification');
    }

    public function index() {
        $data = [
            'title' => 'Pengembalian Aset',
            'returns' => $this->returnModel->getAllWithDetails()
        ];

        $this->view('returns/index', $data);
    }

    public function create($borrowingId) {
        $borrowing = $this->borrowingModel->getById($borrowingId);
        
        if ($borrowing['status'] !== 'approved') {
            setFlash('danger', 'Peminjaman belum dapat dikembalikan');
            $this->redirect('borrow');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Create return record with pending status
            $returnData = [
                'borrowing_id' => $borrowingId,
                'return_date' => date('Y-m-d H:i:s'),
                'condition' => sanitize($_POST['condition']),
                'notes' => sanitize($_POST['notes']),
                'status' => 'pending_return',
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->returnModel->create($returnData)) {
                // Update borrowing status to pending_return
                $this->borrowingModel->updateStatus($borrowingId, 'pending_return');

                // Create notification
                $notifData = [
                    'user_id' => $borrowing['user_id'],
                    'title' => 'Pengembalian Diajukan',
                    'message' => 'Pengembalian untuk peminjaman ' . $borrowing['borrow_code'] . ' sedang diproses admin',
                    'type' => 'info',
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->notificationModel->create($notifData);

                setFlash('success', 'Pengembalian berhasil diajukan. Menunggu verifikasi admin.');
                $this->redirect('borrow');
            } else {
                setFlash('danger', 'Gagal mencatat pengembalian');
            }
        }

        $data = [
            'title' => 'Form Pengembalian',
            'borrowing' => $borrowing,
            'details' => $this->borrowDetailModel->getByBorrowingId($borrowingId)
        ];

        $this->view('returns/create', $data);
    }

    public function verifications() {
        // Only admin can access
        if (getUserRole() !== 'admin') {
            setFlash('danger', 'Akses ditolak');
            $this->redirect('dashboard');
        }

        $data = [
            'title' => 'Verifikasi Pengembalian',
            'pending_returns' => $this->returnModel->getPendingReturns(),
            'return_history' => $this->returnModel->getReturnHistory()
        ];

        $this->view('returns/verifications', $data);
    }

    public function approve($returnId) {
        // Only admin can access
        if (getUserRole() !== 'admin') {
            jsonResponse(['success' => false, 'message' => 'Akses ditolak']);
            return;
        }

        // Get return details
        $return = $this->returnModel->getReturnWithDetails($returnId);
        
        if (!$return || $return['status'] !== 'pending_return') {
            jsonResponse(['success' => false, 'message' => 'Pengembalian tidak valid']);
            return;
        }

        // Get borrow details to update stock
        $details = $this->borrowDetailModel->getByBorrowingId($return['borrowing_id']);
        
        // Return stock
        foreach ($details as $detail) {
            $this->assetModel->updateStock($detail['asset_id'], $detail['quantity'], 'increase');
        }

        // Update return status
        if ($this->returnModel->updateStatus($returnId, 'returned', getUserId())) {
            // Update borrowing status
            $this->borrowingModel->updateStatus($return['borrowing_id'], 'returned');

            // Create notification
            $notifData = [
                'user_id' => $return['user_id'],
                'title' => 'Pengembalian Disetujui',
                'message' => 'Pengembalian untuk peminjaman ' . $return['borrow_code'] . ' telah disetujui',
                'type' => 'success',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->notificationModel->create($notifData);

            setFlash('success', 'Pengembalian berhasil disetujui');
            $this->redirect('return/verifications');
        } else {
            setFlash('danger', 'Gagal menyetujui pengembalian');
            $this->redirect('return/verifications');
        }
    }

    public function reject($returnId) {
        // Only admin can access
        if (getUserRole() !== 'admin') {
            jsonResponse(['success' => false, 'message' => 'Akses ditolak']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            setFlash('danger', 'Invalid request');
            $this->redirect('return/verifications');
            return;
        }

        // Get return details
        $return = $this->returnModel->getReturnWithDetails($returnId);
        
        if (!$return || $return['status'] !== 'pending_return') {
            setFlash('danger', 'Pengembalian tidak valid');
            $this->redirect('return/verifications');
            return;
        }

        $rejectionReason = sanitize($_POST['rejection_reason']);
        
        if (empty($rejectionReason)) {
            setFlash('danger', 'Alasan penolakan harus diisi');
            $this->redirect('return/verifications');
            return;
        }

        // Update return status
        if ($this->returnModel->updateStatus($returnId, 'rejected', getUserId(), $rejectionReason)) {
            // Update borrowing status back to approved (student can resubmit)
            $this->borrowingModel->updateStatus($return['borrowing_id'], 'approved');

            // Create notification
            $notifData = [
                'user_id' => $return['user_id'],
                'title' => 'Pengembalian Ditolak',
                'message' => 'Pengembalian untuk peminjaman ' . $return['borrow_code'] . ' ditolak: ' . $rejectionReason,
                'type' => 'danger',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->notificationModel->create($notifData);

            setFlash('success', 'Pengembalian berhasil ditolak');
            $this->redirect('return/verifications');
        } else {
            setFlash('danger', 'Gagal menolak pengembalian');
            $this->redirect('return/verifications');
        }
    }
}
