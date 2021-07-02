<?php

require_once(dirname(__FILE__) . '/../domain/JobChangeEntity.php');
require_once(dirname(__FILE__) . '/../Repository/JobChangeRepository.php');
require_once(dirname(__FILE__) . '/../repository/MysqlRepository.php');

/**
 * 転職事由のアプリケーションクラス。
 * 転職自由のユースケースを記載するクラス。
 */

class JobChangeApplication
{
    private $jobChangeRepository; // 転職事由リポジトリ

    public function __construct()
    {
        $mysql = new Mysql();
        $this->jobChangeRepository = new JobChangeRepository($mysql->getPdo());
    }

    /**
     * 転職事由を作成する。
     * @param array $jobChange 転職事由の配列。
     * @return string エラーコード。
     */
    public function createJobChange(array $jobChange): string
    {
        $jobChangeEntity = new JobChangeEntity($jobChange);
        $errorCode = $this->jobChangeRepository->createJobChange($jobChangeEntity);

        return $errorCode;
    }

    /**
     * 転職事由を削除する。
     * @param array $jobChange 転職事由の配列。
     * @return string エラーコード。
     */
    public function deleteJobChange(array $jobChange): string
    {
        $jobChangeEntity = new JobChangeEntity($jobChange);
        $errorCode = $this->jobChangeRepository->deleteJobChange($jobChangeEntity);

        return $errorCode;
    }
}
