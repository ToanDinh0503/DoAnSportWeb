<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/User.php';

try {
    $database = Database::getInstance();
    $db = $database->getConnection();
    $user = new User($db);

    $searchTerm = $_GET['search'] ?? '';

    $users = $user->search($searchTerm);

    echo json_encode(['success' => true, 'users' => $users]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
