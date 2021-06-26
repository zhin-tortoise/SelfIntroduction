<?php

/**
 * Mysqlへの接続を管理するクラス
 */

class Mysql
{
    // const ENVIRONMENT = 'production';
    const ENVIRONMENT = 'develop';
    private string $mysqlEnvironmentFilePath;
    private $pdo;

    /**
     * コンストラクタでPDOの作成を行う。
     */
    public function __construct()
    {
        $this->mysqlEnvironmentFilePath = dirname(__FILE__) . '/Mysql.json';
        $environment = json_decode(file_get_contents($this->mysqlEnvironmentFilePath), true)[self::ENVIRONMENT];
        $this->pdo = new PDO("mysql:dbname=$environment[name];host=$environment[host];", $environment['user'], $environment['password']);
    }

    /**
     * PDOのゲッター。
     * @return PDO pdo。
     */
    public function getPdo()
    {
        return $this->pdo;
    }
}
