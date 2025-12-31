<?php
// Connect to shared MariaDB
$conn = new mysqli("mysql-db", "root", "", "lab_sqli_2");

// If database doesn't exist, create it and initialize
if ($conn->connect_error) {
    $tmp_conn = new mysqli("mysql-db", "root", "");
    $tmp_conn->query("CREATE DATABASE IF NOT EXISTS lab_sqli_2");
    $tmp_conn->close();
    $conn = new mysqli("mysql-db", "root", "", "lab_sqli_2");
}

// Setup tables
$conn->query("CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50), password VARCHAR(50), role VARCHAR(50))");
$result = $conn->query("SELECT * FROM users");
if ($result && $result->num_rows == 0) {
    $conn->query("INSERT INTO users (username, password, role) VALUES ('admin', 'p@ssword456', 'administrator'), ('user', 'user456', 'user'), ('guest', 'guest', 'guest')");
}

$id = $_GET['id'] ?? '1';

if (isset($_GET['id'])) {
    $sql = "SELECT id, username, role FROM users WHERE id = '" . $id . "'";
    $result = $conn->query($sql);
    
    if (!$result) {
        $error = $conn->error;
    } else {
        $row = $result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SQLi Lab 2 - Error Based</title>
    <style>
        body { font-family: 'Outfit', sans-serif; padding: 50px; background: #0f172a; color: white; }
        .container { max-width: 800px; margin: auto; background: #1e293b; padding: 30px; border-radius: 12px; border: 1px solid #334155; }
        .user-card { background: #334155; padding: 15px; border-radius: 8px; margin-top: 20px; }
        .error { background: #450a0a; border: 1px solid #991b1b; color: #fecaca; padding: 15px; border-radius: 8px; margin-top: 20px; font-family: monospace; }
        input { padding: 8px; border-radius: 4px; border: 1px solid #475569; background: #0f172a; color: white; }
        button { padding: 8px 16px; background: #22c55e; border: none; border-radius: 4px; color: white; cursor: pointer; }
        .hint { margin-top: 30px; padding: 15px; background: #1e1b4b; border: 1px solid #3730a3; border-radius: 8px; font-size: 0.9em; }
        code { color: #f472b6; }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Detail Lookup</h1>
        <p>Enter User ID (string) to view details:</p>
        <form action="">
            <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <button type="submit">Lookup</button>
        </form>

        <?php if (isset($row)): ?>
            <div class="user-card">
                <p><strong>ID:</strong> <?php echo $row['id']; ?></p>
                <p><strong>Username:</strong> <?php echo $row['username']; ?></p>
                <p><strong>Role:</strong> <?php echo $row['role']; ?></p>
            </div>
        <?php elseif (isset($error)): ?>
            <div class="error">
                <strong>Database Error:</strong> <?php echo $error; ?>
            </div>
        <?php elseif (isset($sql)): ?>
             <p style="color: #64748b;">No user found.</p>
        <?php endif; ?>

        <div class="hint">
            <strong>Hint:</strong> This lab is vulnerable to Error-based SQL injection. The backend displays database errors. Try to extract information using <code>updatexml()</code> or <code>extractvalue()</code>.
            <br>
            <code>?id=1' AND updatexml(1,concat(0x7e,(SELECT password FROM users LIMIT 0,1)),1)-- -</code>
        </div>
    </div>
</body>
</html>
