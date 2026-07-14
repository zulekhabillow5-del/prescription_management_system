<?php
// Simple TCP test for DB host:port
$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: 3306;
$timeout = 5;
header('Content-Type: text/plain');
if (empty($host)) {
    echo "DB_HOST not set\n";
    exit;
}
$start = microtime(true);
$fp = @fsockopen($host, (int)$port, $errno, $errstr, $timeout);
$elapsed = round(microtime(true) - $start, 3);
if ($fp) {
    echo "TCP OK: Connected to $host:$port (in {$elapsed}s)\n";
    fclose($fp);
} else {
    echo "TCP FAILED: could not connect to $host:$port\n";
    echo "Error: $errstr ($errno)\n";
    echo "Elapsed: {$elapsed}s\n";
}
?>