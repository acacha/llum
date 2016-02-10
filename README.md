# llum

Installer for https://github.com/acacha/llum

# Install notes

```bash
composer global require "acacha/llum=~0.1"
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
