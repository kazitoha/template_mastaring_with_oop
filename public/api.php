<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../config/CommonFunction.php'; // Assuming Model is a base class
header('Content-Type: application/json');

// Get the model name dynamically (e.g., from the URL or request)
$modelName = $_GET['model'] ?? 'User'; // Default to User if model is not provided

// Dynamically load the model class (e.g., User.php, Product.php, etc.)
$modelClass = __DIR__ . '/../app/models/' . $modelName . '.php';
if (file_exists($modelClass)) {
    require_once $modelClass;
} else {
    echo json_encode(['error' => 'Model not found']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['page'])) {
        // Pagination handling
        $page = $_GET['page'];
        $limit = 5;  // Set the number of items per page
        $offset = ($page - 1) * $limit;

        // Instantiate the model and get data
        $model = new $modelName();
        $data = $model->getPaginated($limit, $offset);
        $total = $model->count();
        echo json_encode([
            'data' => $data,
            'total' => $total
        ]);
    } else {
        echo json_encode(['error' => 'Page not specified']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create a new record
    $data = json_decode(file_get_contents('php://input'), true);
    $model = new $modelName();
    $result = $model->create($data);
    echo json_encode(['success' => $result]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Update an existing record
    $data = json_decode(file_get_contents('php://input'), true);
    $model = new $modelName();
    $result = $model->update($data['id'], $data);
    echo json_encode(['success' => $result]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Delete a record
    $data = json_decode(file_get_contents('php://input'), true);
    $model = new $modelName();
    $result = $model->delete($data['id']);
    echo json_encode(['success' => $result]);
}
