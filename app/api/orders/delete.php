<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/DonHang.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
        throw new Exception('Method not allowed');
    }

    $id = $_POST['id'] ?? $_GET['id'] ?? null;
    if (!$id) {
        throw new Exception('ID đơn hàng không được cung cấp');
    }

    $database = Database::getInstance();
    $db = $database->getConnection();
    $donHang = new DonHang($db);

    // Lấy thông tin đơn hàng để kiểm tra trước khi xóa
    $order = $donHang->getOrderById($id);
    
    if ($order) {
        // Xóa đơn hàng từ database
        $donHang->id = $id;
        if ($donHang->delete()) {
            echo json_encode([
                'success' => true,
                'message' => 'Xóa đơn hàng thành công'
            ]);
        } else {
            throw new Exception('Không thể xóa đơn hàng');
        }
    } else {
        throw new Exception('Không tìm thấy đơn hàng');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
