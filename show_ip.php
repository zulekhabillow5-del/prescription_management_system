<?php
// Shows the public outbound IP of the running service
header('Content-Type: text/plain');
$ip = @file_get_contents('https://api.ipify.org');
if ($ip === false) {
    echo "Unable to fetch external IP. Try again or open a shell on Render to run: curl https://api.ipify.org\n";
} else {
    echo "Outbound IP: " . trim($ip) . "\n";
}
?>