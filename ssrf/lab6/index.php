<?php
if ($_SERVER['REQUEST_URI'] == '/admin') {
    if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1') {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Internal Management Console</title>
            <style>
                body { font-family: 'Inter', sans-serif; background: #0f172a; color: #f1f5f9; padding: 40px; }
                .dashboard { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 30px; max-width: 800px; margin: auto; }
                h1 { color: #38bdf8; margin-top: 0; }
                .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
                .stat-box { background: #0f172a; padding: 15px; border-radius: 8px; border-left: 4px solid #38bdf8; }
                .stat-box h4 { margin: 0; color: #94a3b8; font-size: 0.9em; }
                .stat-box p { margin: 5px 0 0 0; font-weight: bold; font-family: monospace; }
                .secret-key { color: #f43f5e; background: #451a03; padding: 2px 4px; border-radius: 4px; }
            </style>
        </head>
        <body>
            <div class="dashboard">
                <h1>Service Management Panel</h1>
                <p>Welcome, root. All systems nominal.</p>
                <div class="grid">
                    <div class="stat-box"><h4>Local Cache Size</h4><p>256 MB</p></div>
                    <div class="stat-box"><h4>Master API Token</h4><p class="secret-key">sk_live_9912_adm_88</p></div>
                    <div class="stat-box"><h4>Internal Proxy</h4><p>enabled</p></div>
                    <div class="stat-box"><h4>Last Scan</h4><p>12:44:01 UTC</p></div>
                </div>
                <p style="margin-top: 25px; color: #64748b; font-size: 0.85em;">Connected via session: 127.0.0.1 (Internal Loopback)</p>
            </div>
        </body>
        </html>
        <?php
    } else {
        header('HTTP/1.1 403 Forbidden');
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
         curl_setopt($ch, CURLOPT_TIMEOUT, 5);
         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
         $res = curl_exec($ch);
         curl_close($ch);
         echo "Request processed.";
    } else if (strpos($url, 'gopher') === 0) {
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_TIMEOUT, 5);
         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
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
