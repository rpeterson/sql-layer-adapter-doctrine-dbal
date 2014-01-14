<?php

namespace FDB\SQL\DBAL\Tests;

use FDB\SQL\DBAL\PDOFoundationDBSQLDriver;
use Doctrine\Tests\DBAL\Functional\Schema\SchemaManagerFunctionalTestCase;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Comparator;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\Schema;

class FoundationDBSQLSchemaManagerTest extends SchemaManagerFunctionalTestCase
{
    protected function setUp()
    {
        $this->_conn = new Connection(
            [
                'driverClass' => 'FDB\\SQL\\DBAL\\PDOFoundationDBSQLDriver',
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

    public function testUpdateSchemaWithForeignKeyRenaming()
    {
        $this->markTestSkipped('Renaming columns with foreign keys is not supported.');
    }

    public function testListDatabases()
    {
        $this->_sm->dropAndCreateDatabase('test_create_database');
        // TODO: Need to create something in the schema for it to list.
        $table = new \Doctrine\DBAL\Schema\Table('test_create_database.test_database_table');
        $table->setSchemaConfig($this->_sm->createSchemaConfig());
        $table->addColumn('id', 'integer', array('notnull' => true));
        $table->setPrimaryKey(array('id'));
        $this->_sm->dropAndCreateTable($table);
        $databases = $this->_sm->listDatabases();
        $this->_sm->dropTable($table);
        $databases = \array_map('strtolower', $databases);
        $this->assertEquals(true, \in_array('test_create_database', $databases));
    }

}
