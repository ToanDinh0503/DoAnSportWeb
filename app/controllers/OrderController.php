<?php
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../models/DonHang.php';
require_once __DIR__ . '/../config/database.php';

class OrderController extends BaseController {
    private $donHangModel;

    public function __construct() {
        parent::__construct();
        $this->donHangModel = new DonHang($this->db);
    }

    // Danh sách đơn hàng với phân trang
    public function index($page = 1) {
        try {
            $limit = 10;
            $orders = $this->donHangModel->getAllOrders($page, $limit);
            $totalOrders = $this->donHangModel->getTotalOrders();
            $totalPages = ceil($totalOrders / $limit);

            return [
                'orders' => $orders,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'totalOrders' => $totalOrders
            ];
        } catch (Exception $e) {
            error_log("Error in OrderController::index: " . $e->getMessage());
            return [
                'orders' => [],
                'currentPage' => 1,
                'totalPages' => 0,
                'totalOrders' => 0
            ];
        }
    }

    // Lấy thông tin đơn hàng theo ID
    public function getOrderById($id) {
        try {
            return $this->donHangModel->getOrderById($id) ?? null;
        } catch (Exception $e) {
            error_log("Error in OrderController::getOrderById: " . $e->getMessage());
            return null;
        }
    }

    // Lấy danh sách đơn hàng theo user_id
    public function getOrdersByUser($user_id) {
        try {
            return $this->donHangModel->read($user_id) ?? [];
        } catch (Exception $e) {
            error_log("Error in OrderController::getOrdersByUser: " . $e->getMessage());
            return [];
        }
    }

    // Lấy danh sách đơn hàng theo trạng thái
    public function getOrdersByStatus($status) {
        try {
            return $this->donHangModel->getOrdersByStatus($status) ?? [];
        } catch (Exception $e) {
            error_log("Error in OrderController::getOrdersByStatus: " . $e->getMessage());
            return [];
        }
    }

    // Tạo đơn hàng mới
    public function createOrder($data) {
        try {
            $this->donHangModel->user_id = $data['user_id'];
            $this->donHangModel->tong_tien = $data['tong_tien'];
            $this->donHangModel->phi_van_chuyen = $data['phi_van_chuyen'] ?? 0;
            $this->donHangModel->trang_thai = 'pending';
            $this->donHangModel->ghi_chu = $data['ghi_chu'] ?? '';

            return $this->donHangModel->create();
        } catch (Exception $e) {
            error_log("Error in OrderController::createOrder: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($id, $status) {
        try {
            return $this->donHangModel->updateStatus($id, $status);
        } catch (Exception $e) {
            error_log("Error in OrderController::updateOrderStatus: " . $e->getMessage());
            return false;
        }
    }

    // Xóa đơn hàng
    public function deleteOrder($id) {
        try {
            $this->donHangModel->id = $id;
            return $this->donHangModel->delete();
        } catch (Exception $e) {
            error_log("Error in OrderController::deleteOrder: " . $e->getMessage());
            return false;
        }
    }
}
?>
