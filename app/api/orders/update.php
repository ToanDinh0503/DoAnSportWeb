<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/DonHang.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Method not allowed');
    }

    $database = Database::getInstance();
    $db = $database->getConnection();
    $donHang = new DonHang($db);

    // Lấy đơn hàng hiện tại để kiểm tra trước khi cập nhật
    $existingOrder = $donHang->getOrderById($_POST['id']);
    if (!$existingOrder) {
        throw new Exception('Không tìm thấy đơn hàng');
    }

    $data = [
        'id' => filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT),
        'trang_thai' => filter_var($_POST['trang_thai'], FILTER_SANITIZE_STRING)
    ];

    // Cập nhật trạng thái đơn hàng
    if ($donHang->updateStatus($data['id'], $data['trang_thai'])) {
        echo json_encode([
            'success' => true,
            'message' => 'Cập nhật trạng thái đơn hàng thành công'
        ]);
    } else {
        throw new Exception('Không thể cập nhật đơn hàng');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
