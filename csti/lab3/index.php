<!DOCTYPE html>
<html>
<head>
    <title>Alpine.js CSTI Lab</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: sans-serif; padding: 50px; background: #fff7ed; }
        .container { background: white; padding: 40px; border-radius: 20px; max-width: 600px; margin: auto; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; background: #f97316; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #ea580c; }
        .result { margin-top: 20px; padding: 15px; background: #fed7aa; border-radius: 10px; }
        .info { margin-top: 10px; padding: 10px; background: #ffedd5; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container" x-data="{ open: false, message: '<?php echo addslashes($_GET['payload'] ?? ''); ?>' }">
        <h1>Alpine.js Dashboard</h1>
        <p>This lab demonstrates Client-Side Template Injection in Alpine.js.</p>
        
        <form method="GET" action="">
            <input type="text" name="payload" placeholder="Enter payload..." value="<?php echo htmlspecialchars($_GET['payload'] ?? ''); ?>">
            <button type="submit">Submit</button>
        </form>
        
        <?php if(isset($_GET['payload'])): ?>
        <div class="result">
            <strong>Injected Content:</strong><br>
            <div x-html="message"></div>
            <!-- Vulnerable: User input rendered via x-html in Alpine.js context -->
        </div>
        <?php endif; ?>
        
        <div class="info">
            <button @click="open = !open">Toggle More Info</button>
            <div x-show="open" style="margin-top: 10px;">
                This dashboard uses Alpine.js for reactive components.
            </div>
        </div>
    </div>
</body>
</html>
