<!DOCTYPE html>
<html>
<head>
    <title>Alpine.js CSTI Lab</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: sans-serif; padding: 50px; background: #fff7ed; }
        .container { background: white; padding: 40px; border-radius: 20px; max-width: 600px; margin: auto; }
    </style>
</head>
<body>
    <div class="container" x-data="{ open: false }">
        <h1>Alpine.js Dashboard</h1>
        <p>Injected Content: <?php echo $_GET['payload'] ?? 'None'; ?></p>
        <button @click="open = !open">Toggle More Info</button>
        <div x-show="open">
            More details about the secure dashboard.
        </div>
    </div>
</body>
</html>
