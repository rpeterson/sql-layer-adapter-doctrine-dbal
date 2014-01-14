<?php

namespace FDB\SQL\DBAL\Tests;

use FDB\SQL\DBAL\PDOFoundationDBSQLDriver;
use Doctrine\Tests\DBAL\Functional\Schema\SchemaManagerFunctionalTestCase;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Comparator;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\Schema;

class FoundationDBSqlSchemaManagerTest extends SchemaManagerFunctionalTestCase
{
    protected function setUp()
    {
        $this->_conn = new Connection(
            [
                'host' => $GLOBALS['db_host'],
                'port' => $GLOBALS['db_port'],
                'user' => $GLOBALS['db_username'],
                'password' => $GLOBALS['db_password'],
                'dbname' => $GLOBALS['db_name']
            ],
            new PDOFoundationDBSQLDriver(),
            new Configuration()
        );

        $this->_sm = $this->_conn->getSchemaManager();
        $this->_conn->exec('DROP SCHEMA IF EXISTS doctrine_tests CASCADE');
    }
}
