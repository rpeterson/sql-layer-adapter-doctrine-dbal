DBAL driver for FDB SQL Layer
=============================

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

Because this driver is bundled with Doctrine, it is not available in
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

* Add the driver class to app/config/config.yml and comment out the
  driver, which won't be recognized.

```yaml
doctrine:
    dbal:
        driver_class: "FDB\\SQL\\DBAL\\PDOFoundationDBSQLDriver"
        # driver:   "%database_driver%"
        ...
```

* ```php app/console doctrine:database:create``` should now run without error.
