<!DOCTYPE html>
<html>
<head>
    <title>XSS Lab 1 - Reflected</title>
    <style>
        body { font-family: 'Outfit', sans-serif; padding: 50px; background: #0f172a; color: white; }
        .container { max-width: 800px; margin: auto; background: #1e293b; padding: 30px; border-radius: 12px; border: 1px solid #334155; }
        .search-results { background: #334155; padding: 15px; border-radius: 8px; margin-top: 20px; }
        input { padding: 8px; border-radius: 4px; border: 1px solid #475569; background: #0f172a; color: white; width: 300px; }
        button { padding: 8px 16px; background: #3b82f6; border: none; border-radius: 4px; color: white; cursor: pointer; }
        .hint { margin-top: 30px; padding: 15px; background: #1e1b4b; border: 1px solid #3730a3; border-radius: 8px; font-size: 0.9em; }
        code { color: #f472b6; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Product Search</h1>
        <p>Enter a search term to find products:</p>
        <form action="" method="GET">
            <input type="text" name="q" placeholder="Search..." value="<?php echo isset($_GET['q']) ? $_GET['q'] : ''; ?>">
            <button type="submit">Search</button>
        </form>

        <?php if (isset($_GET['q'])): ?>
            <div class="search-results">
                <h3>Search results for: <?php echo $_GET['q']; ?></h3>
                <p>No products found matching your search. Please try again.</p>
            </div>
        <?php endif; ?>

        <div class="hint">
            <strong>Hint:</strong> This lab is vulnerable to Reflected Cross-Site Scripting (XSS). The search query is reflected back to the page without proper escaping.
            <br>
            <code>?q=&lt;script&gt;alert('XSS')&lt;/script&gt;</code>
        </div>
    </div>
</body>
</html>
