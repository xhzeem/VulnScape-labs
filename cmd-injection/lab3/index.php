<!DOCTYPE html>
<html>
<head>
    <title>Command Injection Lab 3 - Blind</title>
    <style>
        body { font-family: 'Outfit', sans-serif; padding: 50px; background: #0f172a; color: white; }
        .container { max-width: 800px; margin: auto; background: #1e293b; padding: 30px; border-radius: 12px; border: 1px solid #334155; }
        .status-msg { background: #334155; padding: 15px; border-radius: 8px; margin-top: 20px; text-align: center; }
        input { padding: 8px; border-radius: 4px; border: 1px solid #475569; background: #0f172a; color: white; width: 300px; }
        button { padding: 8px 16px; background: #f97316; border: none; border-radius: 4px; color: white; cursor: pointer; }
        .hint { margin-top: 30px; padding: 15px; background: #1e1b4b; border: 1px solid #3730a3; border-radius: 8px; font-size: 0.9em; }
        code { color: #f472b6; }
    </style>
</head>
<body>
    <div class="container">
        <h1>System Health Check</h1>
        <p>Run a quick diagnostic on our internal services:</p>
        <form action="" method="GET">
            <input type="hidden" name="action" value="check">
            <button type="submit">Run Diagnostics</button>
        </form>

        <?php if (isset($_GET['action']) && $_GET['action'] == 'check'): ?>
            <div class="status-msg">
                <?php 
                    // Blind command injection - no output is returned
                    $cmd = "sleep 1"; // Simulating work
                    exec($cmd);
                    echo "Diagnostics complete. All systems operational.";
                ?>
            </div>
        <?php endif; ?>

        <div class="hint">
            <strong>Hint:</strong> This lab is vulnerable to Blind Command Injection via a hidden or inferred parameter. In this case, imagine the 'action' parameter could be manipulated (though here it's simple). Try to use out-of-band techniques or time-based verification.
            <br>
            <code>?action=check; sleep 5</code>
        </div>
    </div>
</body>
</html>
