<?php

require_once(dirname(__FILE__) . '/../Domain/JobChangeEntity.php');
require_once(dirname(__FILE__) . '/../Repository/JobChangeRepository.php');
require_once(dirname(__FILE__) . '/../Repository/MysqlRepository.php');

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
     * ユーザーIDから転職事由を取得する。
     * @param int $userId 取得するユーザーID。
     * @return UserEntity | false 引数で与えられたユーザーIDに紐づく転職事由エンティティ。
     *                            存在しないIDの場合は、falseが返る。
     */
    public function readJobChangeFromUserId(int $userId)
    {
        return $this->jobChangeRepository->readJobChangeFromUserId($userId);
    }

    /**
     * 全ての転職事由を取得する。
     * @return array DBに登録されている全ての転職事由。
     */
    public function readAllJobChange()
    {
        return $this->jobChangeRepository->readAllJobChange();
    }

    /**
     * 転職事由を更新する。
     * @param array $jobChange 転職事由の配列。
     * @return string エラーコード。
     */
    public function updateJobChange(array $jobChange): string
    {
        $jobChangeEntity = new JobChangeEntity($jobChange);

        return $this->jobChangeRepository->updateJobChange($jobChangeEntity);
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
