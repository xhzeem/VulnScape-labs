<?php
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
<head><title>Advanced Proxy</title></head>
<body style="font-family: sans-serif; padding: 50px; background: #fafafa;">
    <div style="background: white; border: 1px solid #ddd; padding: 20px; max-width: 500px; margin: auto;">
        <h1>Service Connector</h1>
        <p>Expert Level: Support for multiple protocols.</p>
        <form>
            <input type="text" name="url" placeholder="gopher://redis:6379/..." style="width: 100%; padding: 10px;">
            <button type="submit" style="margin-top: 10px; padding: 10px; background: #333; color: white; border: none; cursor: pointer;">Connect</button>
        </form>
    </div>
</body>
</html>
<?php
}
?>
