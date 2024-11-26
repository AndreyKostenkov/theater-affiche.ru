<?php
session_start();
include 'includes/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$show_id = $data['show_id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO Favorites (user_id, show_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $show_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>
