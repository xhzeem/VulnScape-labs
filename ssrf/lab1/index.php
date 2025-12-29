<?php
if ($_SERVER['REQUEST_URI'] == '/admin') {
    if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
        echo "u accessed the admin page";
    } else {
        echo "Access Denied: Localhost only.";
    }
    exit;
}

if (isset($_GET['url'])) {
    $url = $_GET['url'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
} else {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Image Proxy</title>
    <style>
        body { font-family: sans-serif; padding: 50px; background: #f0f0f0; }
        .container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input { width: 80%; padding: 10px; margin-bottom: 10px; }
        button { padding: 10px 20px; background: #22c55e; color: white; border: none; cursor: pointer; }
        .hints { margin-top: 30px; padding: 15px; background: #fef3c7; border: 1px solid #f59e0b; border-radius: 5px; }
        .hints h3 { margin-top: 0; color: #92400e; }
        code { background: #fee2e2; padding: 2px 4px; border-radius: 3px; }
        .new-tab-btn { margin-top: 20px; padding: 12px 24px; background: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
        .new-tab-btn:hover { background: #2563eb; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Image Proxy Service</h1>
        <p>Enter an image URL to see it through our proxy:</p>
        <form action="">
            <input type="text" name="url" placeholder="http://example.com/image.jpg">
            <button type="submit">Proxy</button>
        </form>

        <div class="hints">
            <h3>Internal Targets (Hints)</h3>
            <ul>
                <li>Admin Interface: <code>http://127.0.0.1:8081/admin</code></li>
                <li>Secret Service: <code>http://127.0.0.1:8080</code></li>
                <li>Cloud Metadata: <code>http://169.254.169.254/metadata.json</code></li>
            </ul>
        </div>

        <button class="new-tab-btn" onclick="window.open(window.location.href, '_blank')">🔗 Open in New Tab</button>
    </div>
</body>
</html>
<?php
}
?>
