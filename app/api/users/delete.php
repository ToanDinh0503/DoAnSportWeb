<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/User.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
        throw new Exception('Method not allowed');
    }

    $id = $_GET['id'] ?? null;
    if (!$id) {
        throw new Exception('ID người dùng không được cung cấp');
    }

    $database = Database::getInstance();
    $db = $database->getConnection();
    $user = new User($db);

    $user->id = $id;
    if ($user->delete()) {
        echo json_encode(['success' => true, 'message' => 'Xóa người dùng thành công']);
    } else {
        throw new Exception('Không thể xóa người dùng');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
