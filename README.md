# llum

Installer for https://github.com/acacha/llum

# Install notes

```bash
composer global require "acacha/llum=~1.0"
```

# Working notes

Update value in .env file with sed:

```bash
sed -i '/^MAIL_DRIVER=/s/=.*/=log/' .env
```

Comment database entries:

```bash
sed -i 's/^DB_/#DB_/g' .env
```

Add sqlite before database entries:

```bash
sed 's/.*DB_HOST.*/DB_CONNECTION=sqlite\n&/' .env
```

Artisan serve always working:

```php
$continue = true;
$port = 8000;
do {
    echo "Testing with port: ". $port;
    if (check_port($port)) {
        passthru('php artisan serve --port=' . $port);
        $continue=false;
    }
    $port++;
} while ($continue);

echo "END";
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
```
