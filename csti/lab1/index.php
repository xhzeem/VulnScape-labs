<!DOCTYPE html>
<html>
<head>
    <title>Angular CSTI Lab</title>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
    <style>
        body { font-family: sans-serif; padding: 50px; background: #faf5ff; }
        .container { background: white; padding: 40px; border-radius: 20px; max-width: 600px; margin: auto; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; }
        .result { margin-top: 20px; padding: 15px; background: #f3e8ff; border-radius: 10px; }
    </style>
</head>
<body ng-app>
    <div class="container">
        <h1>Angular Search</h1>
        <p>This lab demonstrates Client-Side Template Injection in AngularJS 1.5.0.</p>
        <form method="GET" action="">
            <input type="text" name="q" ng-model="searchQuery" placeholder="Search query..." value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
            <button type="submit">Search</button>
        </form>
        
        <?php if(isset($_GET['q'])): ?>
        <div class="result">
            Searching for: <?php echo $_GET['q']; ?>
            <!-- Vulnerable: PHP echoes input directly into an Angular app context -->
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
