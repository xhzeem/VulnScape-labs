<?php
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
    </div>
</body>
</html>
<?php
}
?>
