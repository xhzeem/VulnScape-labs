<!DOCTYPE html>
<html>
<head>
    <title>Vue.js CSTI Lab</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <style>
        body { font-family: sans-serif; padding: 50px; background: #ecfdf5; }
        .container { background: white; padding: 40px; border-radius: 20px; max-width: 600px; margin: auto; }
        .result { margin-top: 20px; padding: 15px; background: #d1fae5; border-radius: 10px; }
    </style>
</head>
<body>
    <div id="app" class="container">
        <h1>Vue.js Profile</h1>
        <form>
            <input type="text" name="name" placeholder="Update Name">
            <button type="submit">Update</button>
        </form>
        <div class="result">
            Current Profile: <?php echo $_GET['name'] ?? 'Guest'; ?>
        </div>
    </div>
    <script>
        new Vue({ el: '#app' });
    </script>
</body>
</html>
