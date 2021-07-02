<?php

/**
 * 転職事由のリポジトリ。
 * 転職テーブルへのアクセスを担う。
 */

require_once(dirname(__FILE__) . '/IJobChangeRepository.php');
require_once(dirname(__FILE__) . '/../domain/JobChangeEntity.php');

class JobChangeRepository implements IJobChangeRepository
{
    private PDO $pdo; // DBアクセスを行うPDOクラス。

    /**
     * コンストラクタでPDOを設定する。
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 転職事由エンティティを引数から取得し、その転職事由をDBに登録する。
     * @param JobChangeEntity $jobChangeEntity 登録する転職事由。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function createJobChange(JobChangeEntity $jobChangeEntity): string
    {
        $sql = 'insert into job_change values ( ';
        $sql .= ':id, :user_id, :reason, :motivation, :experience ';
        $sql .= ');';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $jobChangeEntity->getId());
        $stmt->bindValue(':user_id', $jobChangeEntity->getUserId());
        $stmt->bindValue(':reason', $jobChangeEntity->getReason());
        $stmt->bindValue(':motivation', $jobChangeEntity->getMotivation());
        $stmt->bindValue(':experience', $jobChangeEntity->getExperience());

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return $e->getCode();
        }

        return $stmt->errorCode();
    }

    /**
     * 転職事由エンティティを引数から取得し、その転職事由をDBから削除する。
     * @param JobChangeEntity $jobChangeEntity 削除する転職事由。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function deleteJobChange(JobChangeEntity $jobChangeEntity): string
    {
        $sql = 'delete from job_change where id = :id;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $jobChangeEntity->getId());
        $stmt->execute();

        return $stmt->errorCode();
    }
}
