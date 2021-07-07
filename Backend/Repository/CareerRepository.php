<?php

/**
 * 経歴のリポジトリ。
 * 経歴テーブルへのアクセスを担う。
 */

require_once(dirname(__FILE__) . '/ICareerRepository.php');
require_once(dirname(__FILE__) . '/../Domain/CareerEntity.php');

class CareerRepository implements ICareerRepository
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
     * 経歴エンティティを引数から取得し、その経歴をDBに登録する。
     * @param CareerEntity $careerEntity 登録する経歴。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function createCareer(CareerEntity $careerEntity): string
    {
        $sql = 'insert into career values ( ';
        $sql .= ':id, :userId, :startDate, :finishDate, :overview, :explainText ';
        $sql .= ');';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $careerEntity->getId());
        $stmt->bindValue(':userId', $careerEntity->getUserId());
        $stmt->bindValue(':startDate', $careerEntity->getStartDate());
        $stmt->bindValue(':finishDate', $careerEntity->getFinishDate());
        $stmt->bindValue(':overview', $careerEntity->getOverview());
        $stmt->bindValue(':explainText', $careerEntity->getExplainText());

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return $e->getCode();
        }

        return $stmt->errorCode();
    }

    /**
     * 経歴IDを引数から取得し、そのIDから経歴を読み取り、経歴エンティティを返す。
     * @param int $id 経歴ID。
     * @return CareerEntity | false 引数で与えられた経歴IDに紐づく経歴エンティティ。
     *                              存在しないIDの場合は、falseが返る。
     */
    public function readCareerFromId(int $id)
    {
        $sql = 'select * from career where id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->rowCount() ? new CareerEntity($stmt->fetch()) : false;
    }

    /**
     * ユーザーIDを引数から取得し、そのIDから経歴を読み取り、経歴エンティティを返す。
     * @param int $userId ユーザーID。
     * @return array 引数で与えられたユーザーIDに紐づく経歴エンティティの配列。
     */
    public function readCareerFromUserId(int $userId): array
    {
        $sql = 'select * from career where userId = :userId';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();

        $careers = [];
        foreach ($stmt->fetchAll() as $career) {
            $careers[] = new CareerEntity($career);
        }
        return $careers;
    }

    /**
     * 全ての経歴を取得する。
     * @return array DBに登録されている全ての経歴エンティティが含まれた配列。
     */
    public function readAllCareer(): array
    {
        $sql = 'select * from career;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $careers = [];
        foreach ($stmt->fetchAll() as $career) {
            $careers[] = new CareerEntity($career);
        }

        return $careers;
    }

    /**
     * 経歴エンティティを引数から取得し、その経歴をDBに更新する。
     * @param CareerEntity $careerEntity 更新する経歴。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function updateCareer(CareerEntity $careerEntity): string
    {
        $sql = 'update career set userId = :userId, startDate = :startDate, finishDate = :finishDate, ';
        $sql .= 'overview = :overview, explainText = :explainText ';
        $sql .= 'where id = :id;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $careerEntity->getId());
        $stmt->bindValue(':userId', $careerEntity->getUserId());
        $stmt->bindValue(':startDate', $careerEntity->getStartDate());
        $stmt->bindValue(':finishDate', $careerEntity->getFinishDate());
        $stmt->bindValue(':overview', $careerEntity->getOverview());
        $stmt->bindValue(':explainText', $careerEntity->getExplainText());
        $stmt->execute();

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return $e->getCode();
        }

        return $stmt->errorCode();
    }

    /**
     * 経歴エンティティを引数から取得し、その経歴をDBから削除する。
     * @param CareerEntity $careerEntity 削除する経歴。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function deleteCareer(CareerEntity $careerEntity): string
    {
        $sql = 'delete from career where id = :id;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $careerEntity->getId());
        $stmt->execute();

        return $stmt->errorCode();
    }
}
