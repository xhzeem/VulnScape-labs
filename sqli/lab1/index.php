<?php
// Connect to MariaDB
$conn = new mysqli("mysql-db", "root", "");

// Ensure database exists
$conn->query("CREATE DATABASE IF NOT EXISTS lab_sqli_1");
$conn->select_db("lab_sqli_1");

// Setup tables
$conn->query("CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50), password VARCHAR(50), role VARCHAR(50))");
$result = $conn->query("SELECT * FROM users");
if ($result && $result->num_rows == 0) {
    $conn->query("INSERT INTO users (username, password, role) VALUES ('admin', 'p@ssword123', 'administrator'), ('user', 'user123', 'user'), ('guest', 'guest', 'guest')");
}

$id = $_GET['id'] ?? '1';

if (isset($_GET['id'])) {
    $sql = "SELECT id, username, role FROM users WHERE id = " . $id;
    $result = $conn->query($sql);
    
    if ($result) {
        $row = $result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SQLi Lab 1 - UNION Based</title>
    <style>
        body { font-family: 'Outfit', sans-serif; padding: 50px; background: #0f172a; color: white; }
        .container { max-width: 800px; margin: auto; background: #1e293b; padding: 30px; border-radius: 12px; border: 1px solid #334155; }
        .user-card { background: #334155; padding: 15px; border-radius: 8px; margin-top: 20px; }
        input { padding: 8px; border-radius: 4px; border: 1px solid #475569; background: #0f172a; color: white; }
        button { padding: 8px 16px; background: #22c55e; border: none; border-radius: 4px; color: white; cursor: pointer; }
        .hint { margin-top: 30px; padding: 15px; background: #1e1b4b; border: 1px solid #3730a3; border-radius: 8px; font-size: 0.9em; }
        code { color: #f472b6; }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Profile Viewer</h1>
        <p>Enter User ID to view profile:</p>
        <form action="">
            <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <button type="submit">View</button>
        </form>

        <?php if (isset($row)): ?>
            <div class="user-card">
                <p><strong>ID:</strong> <?php echo $row['id']; ?></p>
                <p><strong>Username:</strong> <?php echo $row['username']; ?></p>
                <p><strong>Role:</strong> <?php echo $row['role']; ?></p>
            </div>
        <?php elseif (isset($sql)): ?>
             <p style="color: #ef4444;">User not found or query error.</p>
        <?php endif; ?>

        <div class="hint">
            <strong>Hint:</strong> This lab is vulnerable to UNION-based SQL injection. Try to extract the admin password.
            <br>
            <code>?id=1 UNION SELECT 1,password,3 FROM users--</code>
        </div>
    </div>
</body>
</html>
