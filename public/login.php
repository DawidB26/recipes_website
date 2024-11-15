<?php
// login.php
require_once '../includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT user_id, password_hash FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $username;
        echo json_encode(["status" => "success", "message" => "Login successful."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid credentials."]);
    }
}
