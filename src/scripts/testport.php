<?php

$continue = true;
$port = 8000;
do {
    if (check_port($port)) {
        echo "Executing php artisan serve --port=" . $port ." &\n";
        exec('php artisan serve --port=' . $port .' > /dev/null 2>&1 &');
        sleep(1);
        if (file_exists('/usr/bin/sensible-browser')) {
            passthru('/usr/bin/sensible-browser http://localhost:'.$port);
        }
        $continue=false;
    }
    $port++;
} while ($continue);

function check_port($port,$host = '127.0.0.1') {
    $fp = @fsockopen($host, $port,$errno, $errstr, 5);
    if (!$fp) {
        return true;
    } else {
        // port is open and available
        return false;
        fclose($fp);
    }
}
