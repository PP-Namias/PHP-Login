<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    header("Location: login.php");
    exit;
}

$mysqli = require __DIR__ . "/database.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $user_id = $_GET["user_id"];
    
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $mysqli->stmt_init();
    
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }
    
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        header("Location: admin-dashboard.php");
        exit;
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
?>