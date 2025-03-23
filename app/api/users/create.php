<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/User.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Method not allowed');
    }

    $database = Database::getInstance();
    $db = $database->getConnection();
    $user = new User($db);

    $data = json_decode(file_get_contents("php://input"), true);

    // Gán giá trị cho đối tượng User
    $user->username = $data['username'];
    $user->password = $data['password'];
    $user->email = $data['email'];
    $user->ho_ten = $data['ho_ten'];
    $user->so_dien_thoai = $data['so_dien_thoai'];
    $user->dia_chi = $data['dia_chi'];
    $user->role = $data['role'] ?? 'user';  // Mặc định role là 'user'
    $user->trang_thai = $data['trang_thai'] ?? 1; // Mặc định trạng thái là 1

    if ($user->create()) {
        echo json_encode(['success' => true, 'message' => 'Người dùng đã được thêm thành công']);
    } else {
        throw new Exception('Không thể thêm người dùng');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
