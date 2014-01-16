DBAL driver for FDB SQL Layer
=============================

# Prerequisites #

* The FoundationDB SQL Layer should be installed and running.

* PHP and the pgsql PDO driver should be installed.

  * On Ubuntu, the latter is ```sudo apt-get install php5-pgsql```.

* To check that everything is okay, run this from the command line, adjusting the
  host name as needed.

```php
<?php
$dbh = new PDO("pgsql:host=localhost port=15432 dbname=system");
$stmt = $dbh->prepare('SELECT version()');
$stmt->execute();
$row = $stmt->fetch();
echo $row[0] . "\n";
?>
```

# Loading with Composer #

Add a dependency with @beta stability.

```json
    ...
    "require": {
        "php": ">=5.3.3",
        "symfony/symfony": "~2.4",
        "doctrine/orm": "~2.2,>=2.2.3",
        "foundationdb/sql-layer-adapter-doctine-dbal": "~2.4@beta",
        ...
```

# Configuring Symfony #

Because this driver is not currently bundled with Doctrine, it is not available in
the driver menu and a tiny bit of reconfiguration is needed.

* Download Symfony standard without vendors.

* Adjust composer.json as above and run ```composer update```.

* Configure most of the connection in app/config/parameters.yml.

```yaml
parameters:
    database_driver: pdo_fdbsql
    database_host: localhost
    database_port: 15432
    database_name: symfony
    database_user: symfony
    database_password: secret
    ...
```

* Add the driver class to app/config/config.yml and comment out the driver, which
  won't be recognized.

```yaml
doctrine:
    dbal:
        driver_class: "FDB\\SQL\\DBAL\\PDOFoundationDBSQLDriver"
        # driver:   "%database_driver%"
        ...
```

* ```php app/console doctrine:database:create``` should now run without error.

# Contributing #

We welcome pull requests to fix problems that you may encounter.

## Running Tests ##

In order to run unit tests, some pieces of Doctrine itself are needed. Here are the
steps we follow to set it up.

```bash
composer update
rm -rf vendor/doctrine
composer update --prefer-source
cd vendor/doctrine/dbal
composer update
```

Then to run tests
```bash
cp phpunit.xml.dist phpunit.xml
# (make any adjustments for database location)
phpunit
```
