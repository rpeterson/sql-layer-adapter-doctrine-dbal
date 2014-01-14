<?php

namespace FDB\SQL\DBAL\Tests;

use Doctrine\Tests\DBAL\Platforms\AbstractPlatformTestCase;
use FDB\SQL\DBAL\FoundationDBSQLPlatform;
use Doctrine\DBAL\Types\Type;

class FoundationDBSqlPlatformTest extends AbstractPlatformTestCase
{
    public function createPlatform()
    {
        return new FoundationDBSQLPlatform;
    }

    public function getGenerateTableSql()
    {
        return 'CREATE TABLE test (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, test VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))';
    }

    public function getGenerateTableWithMultiColumnUniqueIndexSql()
    {
        return array(
            'CREATE TABLE test (foo VARCHAR(255) DEFAULT NULL, bar VARCHAR(255) DEFAULT NULL)',
            'CREATE UNIQUE INDEX UNIQ_D87F7E0C8C73652176FF8CAA ON test (foo, bar)'
        );
    }

    public function getGenerateAlterTableSql()
    {
        return array(
            'ALTER TABLE mytable ADD quota INT DEFAULT NULL',
            'ALTER TABLE mytable DROP foo',
            'ALTER TABLE mytable ALTER bar SET DATA TYPE VARCHAR(255)',
            "ALTER TABLE mytable ALTER bar DEFAULT 'def'",
            'ALTER TABLE mytable ALTER bar NOT NULL',
            'ALTER TABLE mytable ALTER bloo SET DATA TYPE BOOLEAN',
            "ALTER TABLE mytable ALTER bloo DEFAULT '0'",
            'ALTER TABLE mytable ALTER bloo NOT NULL',
            'ALTER TABLE mytable RENAME TO userlist',
        );
    }

    public function getGenerateIndexSql()
    {
        return 'CREATE INDEX my_idx ON mytable (user_name, last_login)';
    }

    public function testGeneratesSqlSnippets()
    {
        $this->assertEquals('"', $this->_platform->getIdentifierQuoteCharacter(), 'Identifier quote character is not correct');
        $this->assertEquals('column1 || column2 || column3', $this->_platform->getConcatExpression('column1', 'column2', 'column3'), 'Concatenation expression is not correct');
        $this->assertEquals('SUBSTR(column, 5)', $this->_platform->getSubstringExpression('column', 5), 'Substring expression without length is not correct');
        $this->assertEquals('SUBSTR(column, 0, 5)', $this->_platform->getSubstringExpression('column', 0, 5), 'Substring expression with length is not correct');
    }

    public function testGeneratesDDLSnippets()
    {
        $this->assertEquals('CREATE SCHEMA foobar', $this->_platform->getCreateDatabaseSQL('foobar'));
        $this->assertEquals('DROP SCHEMA IF EXISTS foobar CASCADE', $this->_platform->getDropDatabaseSQL('foobar'));
        $this->assertEquals('DROP TABLE foobar', $this->_platform->getDropTableSQL('foobar'));
    }

    public function testGenerateTableWithAutoincrement()
    {
        $table = new \Doctrine\DBAL\Schema\Table('autoinc_table');
        $column = $table->addColumn('id', 'integer');
        $column->setAutoincrement(true);

        $this->assertEquals(array('CREATE TABLE autoinc_table (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL)'), $this->_platform->getCreateTableSQL($table));
    }

    public function testGeneratesTypeDeclarationForIntegers()
    {
        $this->assertEquals(
            'INT',
            $this->_platform->getIntegerTypeDeclarationSQL(array())
        );
        $this->assertEquals(
            'INT GENERATED BY DEFAULT AS IDENTITY',
            $this->_platform->getIntegerTypeDeclarationSQL(array('autoincrement' => true)
        ));
        $this->assertEquals(
            'INT GENERATED BY DEFAULT AS IDENTITY',
            $this->_platform->getIntegerTypeDeclarationSQL(
                array('autoincrement' => true, 'primary' => true)
        ));
    }

    public function testGeneratesTypeDeclarationForStrings()
    {
        $this->assertEquals(
            'CHAR(10)',
            $this->_platform->getVarcharTypeDeclarationSQL(
                array('length' => 10, 'fixed' => true))
        );
        $this->assertEquals(
            'VARCHAR(50)',
            $this->_platform->getVarcharTypeDeclarationSQL(array('length' => 50)),
            'Variable string declaration is not correct'
        );
        $this->assertEquals(
            'VARCHAR(255)',
            $this->_platform->getVarcharTypeDeclarationSQL(array()),
            'Long string declaration is not correct'
        );
    }

    /* Post 2.4.2

    public function testReturnsBinaryTypeDeclarationSQL()
    {
        $this->assertSame('VARCHAR(255) FOR BIT DATA', $this->_platform->getBinaryTypeDeclarationSQL(array()));
        $this->assertSame('VARCHAR(1024) FOR BIT DATA', $this->_platform->getBinaryTypeDeclarationSQL(array('length' => 1024)));
        $this->assertSame('CHAR(255) FOR BIT DATA', $this->_platform->getBinaryTypeDeclarationSQL(array('fixed' => true)));
        $this->assertSame('CHAR(1024) FOR BIT DATA', $this->_platform->getBinaryTypeDeclarationSQL(array('fixed' => true, 'length' => 1024)));
    }

    */

    public function getGenerateUniqueIndexSql()
    {
        return 'CREATE UNIQUE INDEX index_name ON test (test, test2)';
    }

    public function testGeneratesSequenceSqlCommands()
    {
        $sequence = new \Doctrine\DBAL\Schema\Sequence('myseq', 20, 1);
        $this->assertEquals(
            'CREATE SEQUENCE myseq START WITH 1 INCREMENT BY 20 MINVALUE 1',
            $this->_platform->getCreateSequenceSQL($sequence)
        );
        $this->assertEquals(
            'DROP SEQUENCE myseq RESTRICT',
            $this->_platform->getDropSequenceSQL('myseq')
        );
        $this->assertEquals(
            "SELECT NEXT VALUE FOR myseq",
            $this->_platform->getSequenceNextValSQL('myseq')
        );
    }

    public function testDoesNotPreferIdentityColumns()
    {
        $this->assertFalse($this->_platform->prefersIdentityColumns());
    }

    public function testPrefersSequences()
    {
        $this->assertTrue($this->_platform->prefersSequences());
    }

    public function testSupportsIdentityColumns()
    {
        $this->assertTrue($this->_platform->supportsIdentityColumns());
    }

    public function testSupportsSavePoints()
    {
        $this->assertFalse($this->_platform->supportsSavepoints());
    }

    public function testSupportsSequences()
    {
        $this->assertTrue($this->_platform->supportsSequences());
    }

    public function testModifyLimitQuery()
    {
        $sql = $this->_platform->modifyLimitQuery('SELECT * FROM user', 10, 0);
        $this->assertEquals('SELECT * FROM user LIMIT 10 OFFSET 0', $sql);
    }

    public function testModifyLimitQueryWithEmptyOffset()
    {
        $sql = $this->_platform->modifyLimitQuery('SELECT * FROM user', 10);
        $this->assertEquals('SELECT * FROM user LIMIT 10', $sql);
    }

    public function getGenerateForeignKeySql()
    {
        return 'ALTER TABLE test ADD FOREIGN KEY (fk_name_id) REFERENCES other_table (id)';
    }

    protected function getQuotedColumnInPrimaryKeySQL()
    {
        return array(
            'CREATE TABLE "quoted" ("create" VARCHAR(255) NOT NULL, PRIMARY KEY("create"))',
        );
    }

    protected function getQuotedColumnInIndexSQL()
    {
        return array(
            'CREATE TABLE "quoted" ("create" VARCHAR(255) NOT NULL)',
            'CREATE INDEX IDX_22660D028FD6E0FB ON "quoted" ("create")',
        );
    }

    protected function getQuotedColumnInForeignKeySQL()
    {
        return array(
            'CREATE TABLE "quoted" ("create" VARCHAR(255) NOT NULL, foo VARCHAR(255) NOT NULL, "bar" VARCHAR(255) NOT NULL)',
            'ALTER TABLE "quoted" ADD CONSTRAINT FK_WITH_RESERVED_KEYWORD FOREIGN KEY ("create", foo, "bar") REFERENCES "foreign" ("create", bar, "foo-bar")',
            'ALTER TABLE "quoted" ADD CONSTRAINT FK_WITH_NON_RESERVED_KEYWORD FOREIGN KEY ("create", foo, "bar") REFERENCES foo ("create", bar, "foo-bar")',
            'ALTER TABLE "quoted" ADD CONSTRAINT FK_WITH_INTENDED_QUOTATION FOREIGN KEY ("create", foo, "bar") REFERENCES "foo-bar" ("create", bar, "foo-bar")',
        );
    }

    protected function getBitAndComparisonExpressionSql($value1, $value2)
    {   
        return 'BITAND(' . $value1 . ', ' . $value2 . ')';
    } 

    protected  function getBitOrComparisonExpressionSql($value1, $value2)
    {   
        return 'BITOR(' . $value1 . ', ' . $value2 . ')';
    }  

    public function testSchemaNeedsCreation()
    {
        $schemaName = 'schema';
        $actual = $this->_platform->schemaNeedsCreation($schemaName);
        $this->assertEquals(false, $actual);
    }
}