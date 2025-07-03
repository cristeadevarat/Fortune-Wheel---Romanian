<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fortune_wheel";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Only POST method allowed');
    }
    
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $prize = isset($_POST['prize']) ? trim($_POST['prize']) : '';
    $timestamp = isset($_POST['timestamp']) ? $_POST['timestamp'] : date('Y-m-d H:i:s');
    
    if (empty($name) || empty($email) || empty($prize)) {
        throw new Exception('All fields are required');
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }
    
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM winners WHERE email = ?");
    $checkStmt->execute([$email]);
    
    if ($checkStmt->fetchColumn() > 0) {
        throw new Exception('This email has already been used');
    }
    
    $stmt = $pdo->prepare("INSERT INTO winners (name, email, prize, created_at, ip_address) VALUES (?, ?, ?, ?, ?)");
    $result = $stmt->execute([
        $name,
        $email,
        $prize,
        $timestamp,
        $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Winner saved successfully',
            'id' => $pdo->lastInsertId()
        ]);
    } else {
        throw new Exception('Failed to save winner');
    }
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>