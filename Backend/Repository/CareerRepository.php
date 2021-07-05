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
}
