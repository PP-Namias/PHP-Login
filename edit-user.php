
<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== 'admin') {
    header("Location: login.php");
    exit;
}

$mysqli = require __DIR__ . "/database.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $user_id = $_GET["user_id"];
    
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $mysqli->stmt_init();
    
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }
    
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Edit User</h1>
    <form action="update-user.php" method="post">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user["id"]) ?>">
        <div>
            <input type="text" id="name" name="name" placeholder="Fullname" value="<?= htmlspecialchars($user["fullname"]) ?>">
        </div>
        <div>
            <input type="email" id="email" name="email" placeholder="Email Address" value="<?= htmlspecialchars($user["email"]) ?>">
        </div>
        <div>
            <select id="role" name="role">
                <option value="client" <?= $user["role"] === 'client' ? 'selected' : '' ?>>Client</option>
                <option value="admin" <?= $user["role"] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <button>Update</button>
    </form>
</body>
</html>