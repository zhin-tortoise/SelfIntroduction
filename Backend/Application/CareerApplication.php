<?php

require_once(dirname(__FILE__) . '/../Domain/CareerEntity.php');
require_once(dirname(__FILE__) . '/../Repository/CareerRepository.php');
require_once(dirname(__FILE__) . '/../Repository/MysqlRepository.php');

/**
 * 経歴のアプリケーションクラス。
 * 経歴のユースケースを記載するクラス。
 */

class CareerApplication
{
    private $careerRepository; // 経歴リポジトリ

    public function __construct()
    {
        $mysql = new Mysql();
        $this->careerRepository = new CareerRepository($mysql->getPdo());
    }

    /**
     * 経歴を作成する。
     * @param array $career 経歴の配列。
     * @return string エラーコード。
     */
    public function createCareer(array $career): string
    {
        $careerEntity = new CareerEntity($career);
        $errorCode = $this->careerRepository->createCareer($careerEntity);

        return $errorCode;
    }

    /**
     * ユーザーIDから経歴を取得する。
     * @param int $userId 取得するユーザーID。
     * @return CareerEntity | false 引数で与えられたユーザーIDに紐づく経歴エンティティ。
     *                              存在しないIDの場合は、falseが返る。
     */
    public function readCareerFromUserId(int $userId): array
    {
        return $this->careerRepository->readCareerFromUserId($userId);
    }

    /**
     * 全ての経歴を取得する。
     * @return array DBに登録されている全ての経歴。
     */
    public function readAllCareer()
    {
        return $this->careerRepository->readAllCareer();
    }

    /**
     * 経歴を更新する。
     * @param array $career 経歴の配列。
     * @return string エラーコード。
     */
    public function updateCareer(array $career): string
    {
        $careerEntity = new CareerEntity($career);

        return $this->careerRepository->updateCareer($careerEntity);
    }

    /**
     * 経歴を削除する。
     * @param array $career 経歴の配列。
     * @return string エラーコード。
     */
    public function deleteCareer(array $career): string
    {
        $careerEntity = new CareerEntity($career);
        $errorCode = $this->careerRepository->deleteCareer($careerEntity);

        return $errorCode;
    }
}
