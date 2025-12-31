<!DOCTYPE html>
<html>
<head>
    <title>Command Injection Lab 2 - Filtered</title>
    <style>
        body { font-family: 'Outfit', sans-serif; padding: 50px; background: #0f172a; color: white; }
        .container { max-width: 800px; margin: auto; background: #1e293b; padding: 30px; border-radius: 12px; border: 1px solid #334155; }
        pre { background: #0f172a; padding: 15px; border-radius: 8px; margin-top: 20px; color: #4ade80; border: 1px solid #1e293b; overflow-x: auto; }
        input { padding: 8px; border-radius: 4px; border: 1px solid #475569; background: #0f172a; color: white; width: 300px; }
        button { padding: 8px 16px; background: #f97316; border: none; border-radius: 4px; color: white; cursor: pointer; }
        .hint { margin-top: 30px; padding: 15px; background: #1e1b4b; border: 1px solid #3730a3; border-radius: 8px; font-size: 0.9em; }
        code { color: #f472b6; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Network Utility: Secure Ping</h1>
        <p>Enter an IP address to ping (filters applied):</p>
        <form action="" method="GET">
            <input type="text" name="host" placeholder="127.0.0.1" value="<?php echo isset($_GET['host']) ? htmlspecialchars($_GET['host']) : ''; ?>">
            <button type="submit">Ping</button>
        </form>

        <?php if (isset($_GET['host'])): ?>
            <pre><?php 
                $host = $_GET['host'];
                
                // Blacklist common command separators
                $blacklist = array(';', '&&', '||', '|', '`', '$(', '>');
                $clean = true;
                foreach ($blacklist as $char) {
                    if (strpos($host, $char) !== false) {
                        echo "Hacking attempt detected: Use of '" . $char . "' is forbidden.";
                        $clean = false;
                        break;
                    }
                }

                if ($clean) {
                    $cmd = "ping -c 3 " . $host;
                    echo "Running: " . $cmd . "\n\n";
                    system($cmd);
                }
            ?></pre>
        <?php endif; ?>

        <div class="hint">
            <strong>Hint:</strong> This lab has filters for common command separators. Can you bypass them? Consider using newlines or other techniques.
            <br>
            <code>?host=127.0.0.1%0als</code>
        </div>
    </div>
</body>
</html>
