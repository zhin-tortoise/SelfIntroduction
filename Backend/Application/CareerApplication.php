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
}
