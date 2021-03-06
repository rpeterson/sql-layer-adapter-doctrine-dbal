<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */


namespace FDB\SQL\DBAL;

use Doctrine\DBAL\Platforms\Keywords\KeywordList;

/**
 * FoundationDB SQL layer KeywordList
 */
class FoundationDBSQLKeywords extends KeywordList
{
    public function getName()
    {
        return 'FoundationDB SQL';
    }

    protected function getKeywords()
    {
        return array(
            'ALL',
            'ANALYSE',
            'ANALYZE',
            'AND',
            'ANY',
            'AS',
            'ASC',
            'AUTHORIZATION',
            'BETWEEN',
            'BINARY',
            'BOTH',
            'CASE',
            'CAST',
            'CHECK',
            'COLLATE',
            'COLUMN',
            'CONSTRAINT',
            'CREATE',
            'CURRENT_DATE',
            'CURRENT_TIME',
            'CURRENT_TIMESTAMP',
            'CURRENT_USER',
            'DEFAULT',
            'DEFERRABLE',
            'DESC',
            'DISTINCT',
            'DO',
            'ELSE',
            'END',
            'EXCEPT',
            'FALSE',
            'FOR',
            'FOREIGN',
            'FREEZE',
            'FROM',
            'FULL',
            'GRANT',
            'GROUP',
            'HAVING',
            'ILIKE',
            'IN',
            'INITIALLY',
            'INNER',
            'INTERSECT',
            'INTO',
            'IS',
            'ISNULL',
            'JOIN',
            'LEADING',
            'LEFT',
            'LIKE',
            'LIMIT',
            'LOCALTIME',
            'LOCALTIMESTAMP',
            'NATURAL',
            'NEW',
            'NOT',
            'NOTNULL',
            'NULL',
            'OFF',
            'OFFSET',
            'OLD',
            'ON',
            'ONLY',
            'OR',
            'ORDER',
            'OUTER',
            'OVERLAPS',
            'PLACING',
            'PRIMARY',
            'REFERENCES',
            'SELECT',
            'SESSION_USER',
            'SIMILAR',
            'SOME',
            'TABLE',
            'THEN',
            'TO',
            'TRAILING',
            'TRUE',
            'UNION',
            'UNIQUE',
            'USER',
            'USING',
            'VERBOSE',
            'WHEN',
            'WHERE'
        );
    }
}

