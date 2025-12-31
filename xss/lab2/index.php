<?php
$db = new SQLite3('/tmp/guestbook.db');
$db->exec("CREATE TABLE IF NOT EXISTS messages (id INTEGER PRIMARY KEY, name TEXT, message TEXT)");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['message'])) {
    $stmt = $db->prepare('INSERT INTO messages (name, message) VALUES (:name, :message)');
    $stmt->bindValue(':name', $_POST['name']);
    $stmt->bindValue(':message', $_POST['message']);
    $stmt->execute();
    header('Location: index.php');
    exit;
}

$results = $db->query('SELECT name, message FROM messages ORDER BY id DESC');
?>
<!DOCTYPE html>
<html>
<head>
    <title>XSS Lab 2 - Stored</title>
    <style>
        body { font-family: 'Outfit', sans-serif; padding: 50px; background: #0f172a; color: white; }
        .container { max-width: 800px; margin: auto; background: #1e293b; padding: 30px; border-radius: 12px; border: 1px solid #334155; }
        .message-box { background: #334155; padding: 15px; border-radius: 8px; margin-top: 20px; border-left: 4px solid #3b82f6; }
        .message-name { font-weight: bold; color: #60a5fa; margin-bottom: 5px; }
        input, textarea { padding: 8px; border-radius: 4px; border: 1px solid #475569; background: #0f172a; color: white; width: 100%; margin-bottom: 10px; box-sizing: border-box; }
        button { padding: 8px 16px; background: #3b82f6; border: none; border-radius: 4px; color: white; cursor: pointer; }
        .hint { margin-top: 30px; padding: 15px; background: #1e1b4b; border: 1px solid #3730a3; border-radius: 8px; font-size: 0.9em; }
        code { color: #f472b6; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Guestbook</h1>
        <p>Leave a message for us!</p>
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <textarea name="message" placeholder="Your Message" rows="4" required></textarea>
            <button type="submit">Post Message</button>
        </form>

        <hr style="margin: 30px 0; border: 0; border-top: 1px solid #334155;">

        <h3>Recent Messages</h3>
        <?php while ($row = $results->fetchArray()): ?>
            <div class="message-box">
                <div class="message-name"><?php echo $row['name']; ?></div>
                <div class="message-content"><?php echo $row['message']; ?></div>
            </div>
        <?php endwhile; ?>

        <div class="hint">
            <strong>Hint:</strong> This lab is vulnerable to Stored Cross-Site Scripting (XSS). Messages are stored in the database and displayed to every visitor without sanitization.
            <br>
            <code>&lt;img src=x onerror=alert('StoredXSS')&gt;</code>
        </div>
    </div>
</body>
</html>
