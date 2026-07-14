<?php
// Simple mysqli connect test
header('Content-Type: text/plain');
$host = getenv('DB_HOST');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');
$db   = getenv('DB_NAME');
$port = getenv('DB_PORT') ?: 3306;
if (empty($host) || empty($user) || empty($pass) || empty($db)) {
    echo "Missing DB env vars. Ensure DB_HOST, DB_USERNAME, DB_PASSWORD and DB_NAME are set.\n";
    exit;
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $start = microtime(true);
    $conn = mysqli_connect($host, $user, $pass, $db, (int)$port);
    $elapsed = round(microtime(true) - $start, 3);
    echo "MySQL connect OK (in {$elapsed}s)\n";
    mysqli_close($conn);
} catch (mysqli_sql_exception $e) {
    echo "MySQL connect FAILED: " . $e->getMessage() . "\n";
}
?>