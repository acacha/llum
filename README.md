# llum

Speed up you Github/Laravel development workflow illuminating packages with llum:

[![asciicast](https://asciinema.org/a/bym5od3j6qtqh5liv8uwx1qy4.png)](https://asciinema.org/a/bym5od3j6qtqh5liv8uwx1qy4?speed=2&theme=solarized-dark&loop=1&autoplay=1&size=medium)

[![Total Downloads](https://poser.pugx.org/acacha/llum/downloads.png)](https://packagist.org/packages/acacha/llum)
[![Latest Stable Version](https://poser.pugx.org/acacha/llum/v/stable.png)](https://packagist.org/packages/acacha/llum)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/acacha/llum/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/acacha/llum/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/acacha/llum/badges/build.png?b=master)](https://scrutinizer-ci.com/g/acacha/llum/build-status/master)
[![StyleCI](https://styleci.io/repos/51069439/shield?branch=master)](https://styleci.io/repos/51069439)
[![Build Status](https://travis-ci.org/acacha/llum.svg?branch=master)](https://travis-ci.org/acacha/llum)
[![Dependency Status](https://www.versioneye.com/user/projects/58adc5f59ceb4500372646cd/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/58adc5f59ceb4500372646cd)

Now supports Laravel 5.4.

See also:

- https://medium.com/@sergiturbadenas/developer-workflow-automation-with-laravel-and-github-using-acacha-llum-part-1-a5b3e89dedd9

# Install notes

```bash
composer global require "acacha/llum=~1.0"
```

# Requirements

Some commands use bash commands like [GNU sed](https://www.gnu.org/software/sed/) and touch.On Windows you can use [CygWin](https://www.cygwin.com/)  or see [StackOverflow](http://stackoverflow.com/questions/127318/is-there-any-sed-like-utility-for-cmd-exe)

On MAC OS use GNU sed instead of default installed BSD sed

```bash
brew install gnu-sed --with-default-names
```

# Commands

# init

Execute:

```bash
llum init
Please enter your github username (sergi) ? 
Do you want to use our assistant to obtain token via Github API (Y/n)?Y
Github password?
```
To configure your Bithub user and obtain a token to interact with github using llum commands (see github command section below). This command creates file `~/.llumrc` , an example:

```bash
~ cat .llumrc 
; Llum configuration file

[github]
username = acacha
token = token_here
token_name = your token name here
```

You can avoid providing password creating manually this file an putting your personal Github acces token (https://github.com/settings/tokens) on `~/.llumrc` file.

## Github

**IMPORTANT**: Requires previous execution of `llum init` command to work.

### github:init

**IMPORTANT**: Requires previous execution of `llum init` command to work.

This commands initializes a Github repo, create a first commit, create a Github repo and syncs local content with Github repo. The commands executed are:

```bash
git init
git add .
git commit -a -m "Initial version"
llum github:repo
git pull origin master
git push origin master
```

Example:

```bash
$ cd myproject
$ llum github:init
Running command git init...
S'ha inicialitzat un buit dipòsit de Git a /home/sergi/myproject/.git/
Running command git add ....
Running command git commit -a -m "Initial version"...
[master (comissió d'arrel) 563473d] Initial version
 1 file changed, 0 insertions(+), 0 deletions(-)
 ...
Running command llum github:repo...
Repository myproject created
Running command git remote add origin git@github.com:acacha/myproject.git...
Running command git pull origin master...
fatal: Couldn't find remote ref master
Running command git push origin master...
Comptant els objectes: 3, fet.
Escrivint els objectes: 100% (3/3), 216 bytes | 0 bytes/s, fet.
Total 3 (delta 0), reused 0 (delta 0)
To git@github.com:acacha/myproject.git
 * [new branch]      master -> master
```
 
### github:repo

**IMPORTANT**: Requires previous execution of `llum init` command to work.

Create a new Github repo:

```bash
mkdir && cd newrepo
llum github:repo
```

This create a new Github repo called `{yourgithubusername}/newrepo` (the current folder name is used) . You can provide a name for the repo with:

```bash
llum github:repo reponame
```

## boot

Execute commands:

- devtools
- sqlite
- migrate
- serve

And your are ready to go!

## devtools

Install and configure amazing debug tools [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) and [Laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)

```bash
llum devtools
```

# debugbar

You can install only [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) devtool with:

```bash
llum debugbar
```

# idehelper

You can install only [Laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper) devtool with:

```bash
llum idehelper
```

## sqlite

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

## provider

Add a provider to config/app.php file:

```bash
llum provider Acacha\AdminLTETemplateLaravel\Providers\AdminLTETemplateServiceProvider::class
```

## alias

Add an alias/Facade to config/app.php file:

```bash
llum alias Socialite Laravel\Socialite\Facades\Socialite::class
```

## serve

Similar to php artisan serve but some enhacements:

- First tyry to use port 8000 but if is already in use (in mi case so many times this occurs because Laravel homestead is up) then tries with following port numbers (8001, 8002, 8003)
- If sensible-browser command is available then starts browser

```bash
llum serve
Running php artisan serve --port=8002
Opening http://localhost:8002 with default browser
 ```
 
## migrate

Runs php artisan migrate

```bash
llum migrate
```

# Packagist

https://packagist.org/packages/acacha/admin

## Troubleshooting

### GNU sed on MAC OS

Acacha llum need GNU sed to work so replace BSD sed with GNU sed using:

```bash
brew install gnu-sed --with-default-names
```

Check you version of sed with:

```bash
man sed
```

sed GNU version path is:

```bash
$ which sed
/usr/local/bin/sed
```

Instead of default path of BSD sed (installed by default on MAC OS):

```bash
/usr/bin/sed
```

More info at https://github.com/acacha/adminlte-laravel/issues/58

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
