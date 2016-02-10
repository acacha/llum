# llum

Installer for https://github.com/acacha/llum

# Install notes

```bash
composer global require "acacha/llum=~0.1"
```

# Commands

# Sqlite

Once you've installed a new laravel project use sqlite command to active sqlite

```bash
laravel new larapp
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
