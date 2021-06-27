<?php

/**
 * Mysqlのリポジトリの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Repository/MysqlRepository.php');

class TestMysqlRepository extends TestCase
{
    /**
     * PDOを取得する。
     */
    public function testGetPDO(): void
    {
        $filePath = dirname(__FILE__) . '/../Repository/Mysql.json';
        $environment = json_decode(file_get_contents($filePath), true)['develop'];
        $pdo = new PDO("mysql:dbname=$environment[name];host=$environment[host];", $environment['user'], $environment['password']);

        $mysql = new Mysql();
        $this->assertEquals($mysql->getPdo(), $pdo);
    }
}
