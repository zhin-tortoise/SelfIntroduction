<?php

/**
 * 転職事由のリポジトリ。
 * 転職テーブルへのアクセスを担う。
 */

require_once(dirname(__FILE__) . '/IJobChangeRepository.php');
require_once(dirname(__FILE__) . '/../Domain/JobChangeEntity.php');

class JobChangeRepository implements IJobChangeRepository
{
    private $pdo; // DBアクセスを行うPDOクラス。

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
        $sql = 'insert into jobChange values ( ';
        $sql .= ':id, :userId, :reason, :motivation, :experience ';
        $sql .= ');';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $jobChangeEntity->getId());
        $stmt->bindValue(':userId', $jobChangeEntity->getUserId());
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
     * ユーザーIDを引数から取得し、そのIDから転職事由を読み取り、転職事由エンティティを返す。
     * @param int $userId ユーザーID。
     * @return JobChangeEntity | false 引数で与えられたユーザーIDに紐づく転職事由エンティティ。
     *                                 存在しないIDの場合は、falseが返る。
     */
    public function readJobChangeFromUserId(int $userId)
    {
        $sql = 'select * from jobChange where userId = :userId';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();

        return $stmt->rowCount() ? new JobChangeEntity($stmt->fetch()) : false;
    }

    /**
     * 全ての転職事由を取得する。
     * @return array DBに登録されている全ての転職事由エンティティが含まれた配列。
     */
    public function readAllJobChange(): array
    {
        $sql = 'select * from jobChange;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $jobChanges = [];
        foreach ($stmt->fetchAll() as $jobChange) {
            $jobChanges[] = new JobChangeEntity($jobChange);
        }

        return $jobChanges;
    }

    /**
     * 転職事由エンティティを引数から取得し、その転職事由をDBに更新する。
     * @param JobChangeEntity $jobChangeEntity 更新する転職事由。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function updateJobChange(JobChangeEntity $jobChangeEntity): string
    {
        $sql = 'update jobChange set userId = :userId, reason = :reason, ';
        $sql .= 'motivation = :motivation, experience = :experience ';
        $sql .= 'where id = :id;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $jobChangeEntity->getId());
        $stmt->bindValue(':userId', $jobChangeEntity->getUserId());
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
        $sql = 'delete from jobChange where id = :id;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $jobChangeEntity->getId());
        $stmt->execute();

        return $stmt->errorCode();
    }
}
