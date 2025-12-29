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
    
    // Simple check to prevent basic stuff, but allows gopher
    if (strpos($url, 'http') === 0) {
         // Perform request
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $res = curl_exec($ch);
         curl_close($ch);
         echo "Request processed.";
    } else if (strpos($url, 'gopher') === 0) {
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_exec($ch);
         curl_close($ch);
         echo "Request processed (Gopher).";
    } else {
        echo "Invalid protocol.";
    }
} else {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Advanced Proxy</title>
    <style>
        body { font-family: sans-serif; padding: 50px; background: #fafafa; }
        .container { background: white; border: 1px solid #ddd; padding: 20px; max-width: 500px; margin: auto; }
        input { width: 100%; padding: 10px; }
        button { margin-top: 10px; padding: 10px; background: #333; color: white; border: none; cursor: pointer; }
        .hints { margin-top: 30px; padding: 15px; background: #fef2f2; border: 1px solid #ef4444; border-radius: 5px; }
        .hints h3 { margin-top: 0; color: #b91c1c; }
        code { background: #fee2e2; padding: 2px 4px; border-radius: 3px; }
        .new-tab-btn { margin-top: 20px; padding: 12px 24px; background: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
        .new-tab-btn:hover { background: #2563eb; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Service Connector</h1>
        <p>Expert Level: Support for multiple protocols.</p>
        <form>
            <input type="text" name="url" placeholder="gopher://redis:6379/..." style="width: 100%; padding: 10px;">
            <button type="submit">Connect</button>
        </form>
        <div class="hints">
            <h3>Internal Targets (Hints)</h3>
            <ul>
                <li>Admin Interface: <code>http://127.0.0.1:8086/admin</code></li>
                <li>Secret Service: <code>http://127.0.0.1:8080</code></li>
                <li>Cloud Metadata: <code>http://169.254.169.254/metadata.json</code></li>
                <li>Internal Redis: <code>redis:6379</code></li>
            </ul>
        </div>

        <button class="new-tab-btn" onclick="window.open(window.location.href, '_blank')">🔗 Open in New Tab</button>
    </div>
</body>
</html>
<?php
}
?>
