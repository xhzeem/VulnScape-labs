<?php
// Connect to MariaDB
$conn = new mysqli("mysql-db", "root", "");

// Ensure database exists
$conn->query("CREATE DATABASE IF NOT EXISTS lab_sqli_3");
$conn->select_db("lab_sqli_3");

// Setup tables
$conn->query("CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50), password VARCHAR(50), role VARCHAR(50))");
$result = $conn->query("SELECT * FROM users");
if ($result && $result->num_rows == 0) {
    $conn->query("INSERT INTO users (username, password, role) VALUES ('admin', 'p@ssword789', 'administrator'), ('user', 'user789', 'user'), ('guest', 'guest', 'guest')");
}

$id = $_GET['id'] ?? '1';

if (isset($_GET['id'])) {
    $sql = "SELECT id FROM users WHERE id = '" . $id . "'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $found = true;
    } else {
        $found = false;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SQLi Lab 3 - Blind Based</title>
    <style>
        body { font-family: 'Outfit', sans-serif; padding: 50px; background: #0f172a; color: white; }
        .container { max-width: 800px; margin: auto; background: #1e293b; padding: 30px; border-radius: 12px; border: 1px solid #334155; }
        .status-box { padding: 15px; border-radius: 8px; margin-top: 20px; text-align: center; font-weight: bold; }
        .exists { background: #064e3b; color: #6ee7b7; border: 1px solid #059669; }
        .missing { background: #450a0a; color: #fecaca; border: 1px solid #991b1b; }
        input { padding: 8px; border-radius: 4px; border: 1px solid #475569; background: #0f172a; color: white; }
        button { padding: 8px 16px; background: #22c55e; border: none; border-radius: 4px; color: white; cursor: pointer; }
        .hint { margin-top: 30px; padding: 15px; background: #1e1b4b; border: 1px solid #3730a3; border-radius: 8px; font-size: 0.9em; }
        code { color: #f472b6; }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Existence Checker</h1>
        <p>Enter User ID to check if it exists in our system:</p>
        <form action="">
            <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <button type="submit">Check</button>
        </form>

        <?php if (isset($found)): ?>
            <?php if ($found): ?>
                <div class="status-box exists">
                    User exists in the database.
                </div>
            <?php else: ?>
                <div class="status-box missing">
                    User NOT found.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="hint">
            <strong>Hint:</strong> This lab is vulnerable to Blind SQL injection (Boolean based). No error messages or data are returned. You must infer information based on the "exists" or "NOT found" response.
            <br>
            <code>?id=1' AND SUBSTR((SELECT password FROM users LIMIT 0,1),1,1)='p'-- -</code>
        </div>
    </div>
</body>
</html>
