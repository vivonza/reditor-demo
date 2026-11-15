<?php
/**
 * REditor Unified API Backend (api.php?action=...)
 */
header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? '';
$input = json_decode(file_get_contents('php://input'), true) ?: [];

switch ($action) {
    case 'list':
        // Return media items list
        echo json_encode([
            'current_page' => 1,
            'last_page' => 1,
            'data' => []
        ]);
        break;

    case 'upload':
        // Handle file upload
        if (!isset($_FILES['file'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'No file uploaded']);
            exit;
        }
        // Save file logic here...
        echo json_encode([
            'success' => true,
            'data' => [
                'id' => time(),
                'url' => 'uploads/' . $_FILES['file']['name'],
                'mime_type' => $_FILES['file']['type']
            ]
        ]);
        break;

    case 'widgets':
        echo json_encode(['success' => true, 'widgets' => []]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
        break;
}