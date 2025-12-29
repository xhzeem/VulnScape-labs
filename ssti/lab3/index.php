<?php
require_once '/app/vendor/autoload.php';

$loader = new \Twig\Loader\ArrayLoader();
$twig = new \Twig\Environment($loader);

$name = isset($_GET['name']) ? $_GET['name'] : 'Guest';

// Vulnerable: creating a template from user input
$template = $twig->createTemplate("Hello $name!");
?>
<!DOCTYPE html>
<html>
<head><title>Twig Lab</title></head>
<body style="font-family: sans-serif; padding: 50px; background: #f0fdf4;">
    <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); max-width: 600px; margin: auto;">
        <?php echo $template->render(['flag' => 'FLAG{TWIG_PHP_CMD_EXEC}']); ?>
        <hr>
        <form>
            <input type="text" name="name" placeholder="Your Name" style="padding: 10px; width: 80%;">
            <button type="submit" style="padding: 10px; background: #22c55e; color: white; border: none; cursor: pointer;">Render</button>
        </form>
    </div>
</body>
</html>
