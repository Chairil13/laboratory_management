<?php

class DashboardController extends Controller {
    private $assetModel;
    private $borrowingModel;
    private $notificationModel;

    public function __construct() {
        $this->requireLogin();
        $this->assetModel = $this->model('Asset');
        $this->borrowingModel = $this->model('Borrowing');
        $this->notificationModel = $this->model('Notification');
    }

    public function index() {
        $data = [
            'title' => 'Dashboard',
            'total_assets' => $this->assetModel->getTotalAssets(),
            'available_assets' => $this->assetModel->getAvailableCount(),
            'borrowed_assets' => $this->assetModel->getBorrowedCount(),
            'pending_requests' => $this->borrowingModel->getPendingCount(),
            'active_borrowings' => $this->borrowingModel->getActiveBorrowings(),
            'notifications' => $this->notificationModel->getByUserId(getUserId(), 5)
        ];

        // Role-specific data
        if (getUserRole() === 'user') {
            $data['my_borrowings'] = $this->borrowingModel->getByUserId(getUserId());
            $data['available_assets_list'] = $this->assetModel->getAvailableAssets();
        } elseif (getUserRole() === 'kepala_lab') {
            $data['pending_approvals'] = $this->borrowingModel->getByStatus('pending');
        }

        $this->view('dashboard/index', $data);
    }
}
