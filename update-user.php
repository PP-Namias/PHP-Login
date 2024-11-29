
<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    header("Location: login.php");
    exit;
}

$mysqli = require __DIR__ . "/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST["user_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    
    $sql = "UPDATE users SET fullname = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $mysqli->stmt_init();
    
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }
    
    $stmt->bind_param("sssi", $name, $email, $role, $user_id);
    
    if ($stmt->execute()) {
        header("Location: admin-dashboard.php");
        exit;
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
?>