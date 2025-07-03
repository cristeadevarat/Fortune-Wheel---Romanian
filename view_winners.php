<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spin_win_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Eroare de conectare la baza de date: ' . $conn->connect_error]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $prize = htmlspecialchars($_POST['prize'] ?? '');
    $timestamp = htmlspecialchars($_POST['timestamp'] ?? date('Y-m-d H:i:s'));

    if (empty($name) || empty($email) || empty($prize)) {
        echo json_encode(['success' => false, 'message' => 'Toate câmpurile sunt obligatorii.']);
        $conn->close();
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO winners (name, email, prize, timestamp) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Eroare la pregătirea interogării: ' . $conn->error]);
        $conn->close();
        exit();
    }

    $stmt->bind_param("ssss", $name, $email, $prize, $timestamp);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Datele au fost salvate cu succes.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Eroare la salvarea datelor: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Metodă de cerere invalidă.']);
}

$conn->close();
?>