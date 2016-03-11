# llum

Speed up you laravel development workflow illuminating packages with llum:

[![asciicast](https://asciinema.org/a/bym5od3j6qtqh5liv8uwx1qy4.png)](https://asciinema.org/a/bym5od3j6qtqh5liv8uwx1qy4?speed=2&theme=solarized-dark&loop=1&autoplay=1&size=medium)

<iframe src="http://showterm.io/7b5f8d42ba021511e627e" width="640" height="480"></iframe>

[![Total Downloads](https://poser.pugx.org/acacha/llum/downloads.png)](https://packagist.org/packages/acacha/llum)
[![Latest Stable Version](https://poser.pugx.org/acacha/llum/v/stable.png)](https://packagist.org/packages/acacha/llum)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/acacha/llum/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/acacha/llum/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/acacha/llum/badges/build.png?b=master)](https://scrutinizer-ci.com/g/acacha/llum/build-status/master)
[![Build Status](https://travis-ci.org/acacha/llum.svg?branch=master)](https://travis-ci.org/acacha/llum)

# Install notes

```bash
composer global require "acacha/llum=~0.1"
```

# Requirements

Some commands use bash commands like [GNU sed](https://www.gnu.org/software/sed/) and touch.On Windows you can use [CygWin](https://www.cygwin.com/)  or see [StackOverflow](http://stackoverflow.com/questions/127318/is-there-any-sed-like-utility-for-cmd-exe)

# Commands

##boot

Execute commands:

- devtools
- sqlite
- migrate
- serve

And your are ready to go!

##devtools

Install and configure amazing debug tools [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) and [Laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)

```bash
llum devtools
```

#debugbar

You can install only [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) devtool with:

```bash
llum debugbar
```

#idehelper

You can install only [Laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper) devtool with:

```bash
llum idehelper
```

##sqlite

Once you've installed a new laravel project use sqlite command to active sqlite

```bash
laravel new larapp
cd larapp
llum sqlite
File database/database.sqlite created successfully
.env file updated successfully
```
And sqlite is ready to go:
 
```bash
php artisan migrate 
Migration table created successfully.
Migrated: 2014_10_12_000000_create_users_table
Migrated: 2014_10_12_100000_create_password_resets_table
```

##provider

Add a provider to config/app.php file:

```bash
llum provider Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class
```

##alias

Add an alias/Facade to config/app.php file:

```bash
llum alias Socialite Laravel\Socialite\Facades\Socialite::class
```

##serve

Similar to php artisan serve but some enhacements:

- First tyry to use port 8000 but if is already in use (in mi case so many times this occurs because Laravel homestead is up) then tries with following port numbers (8001, 8002, 8003)
- If sensible-browser command is available then starts browser

```bash
llum serve
Running php artisan serve --port=8002
Opening http://localhost:8002 with default browser
 ```
 
##migrate

Runs php artisan migrate

```bash
llum migrate
```

#Packagist

https://packagist.org/packages/acacha/admin

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

<pre>
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
</pre>

Solution with php preg_replace function:

```php
file_put_contents(base_path('.env'), preg_replace("/(MAIL_DRIVER)=(.*)/", "$1=log", file_get_contents(base_path('.env'))));
```
Insert provider in config/app.php file:
```bash
sed '/.*#llum_providers.*/a \\tBarryvdh\\LaravelIdeHelper\\IdeHelperServiceProvider::class,\n' config/app.php
```
