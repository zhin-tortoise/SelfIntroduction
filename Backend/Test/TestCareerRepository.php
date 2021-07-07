<?php

/**
 * 経歴の振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Repository/MysqlRepository.php');
require_once(dirname(__FILE__) . '/../Repository/CareerRepository.php');
require_once(dirname(__FILE__) . '/../Domain/CareerEntity.php');
require_once(dirname(__FILE__) . '/../Repository/UserRepository.php');
require_once(dirname(__FILE__) . '/../Domain/UserEntity.php');

class TestCareerRepository extends TestCase
{
    const SUCCESS_CODE = '00000'; // リポジトリから返される成功時のステータスコード。

    private int $id = 100; // 経歴ID
    private int $userId = 1000; // ユーザーID
    private string $startDate = '2021/07/05'; // 開始日
    private string $finishDate = '2021/07/06'; // 終了日
    private string $overview = '概要'; // 概要
    private string $explainText = '説明'; // 説明
    private array $career; // 経歴作成用の配列

    private CareerRepository $careerRepository; // 経歴のリポジトリ
    private UserRepository $userRepository; // ユーザーのリポジトリ

    /**
     * 経歴エンティティ作成用の配列を用意する。
     * 経歴のリポジトリを用意する。
     */
    public function setUp(): void
    {
        // 経歴エンティティ作成用の配列を用意する。
        $this->career = [
            'id' => $this->id,
            'userId' => $this->userId,
            'startDate' => $this->startDate,
            'finishDate' => $this->finishDate,
            'overview' => $this->overview,
            'explainText' => $this->explainText
        ];

        // 経歴のリポジトリを用意する。
        $mysql = new Mysql();
        $this->careerRepository = new CareerRepository($mysql->getPdo());

        // ユーザーを作成する。
        $this->userRepository = new UserRepository($mysql->getPdo());
        $userEntity = new UserEntity(['id' => $this->userId]);
        $this->userRepository->createUser($userEntity);
    }

    /**
     * ユーザーを削除する。
     */
    public function tearDown(): void
    {
        $userEntity = new UserEntity(['id' => $this->userId]);
        $this->userRepository->deleteUser($userEntity);
    }

    /**
     * 経歴エンティティを作成し、DBに登録する。
     */
    public function testCreateCareer(): void
    {
        $careerEntity = new CareerEntity($this->career);
        $errorCode = $this->careerRepository->createCareer($careerEntity);

        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * IDが空の経歴エンティティを作成し、DBに登録する。
     */
    public function testCreateEmptyIdCareer(): void
    {
        $career = $this->career;
        $career['id'] = '';
        $careerEntity = new CareerEntity($career);
        $errorCode = $this->careerRepository->createCareer($careerEntity);

        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * IDから経歴エンティティを取得する。
     */
    public function testReadCareerFromId(): void
    {
        $careerEntity = new CareerEntity($this->career);
        $this->careerRepository->createCareer($careerEntity);
        $dbCareerEntity = $this->careerRepository->readCareerFromId($this->career['id']);

        $this->assertSame($dbCareerEntity->getId(), (string)$this->career['id']);
    }

    /**
     * ユーザーIDから経歴エンティティを取得する。
     */
    public function testReadCareerFromUserId(): void
    {
        $careerEntity = new CareerEntity($this->career);
        $this->careerRepository->createCareer($careerEntity);
        $careers = $this->careerRepository->readCareerFromUserId($this->career['userId']);

        $this->assertFalse(empty($careers));
    }

    /**
     * 全ての経歴エンティティを取得する。
     */
    public function testReadAllCareer(): void
    {
        $careerEntity = new CareerEntity($this->career);
        $this->careerRepository->createCareer($careerEntity);
        $careers = $this->careerRepository->readAllCareer();

        $this->assertFalse(empty($careers));
    }

    /**
     * 経歴エンティティを更新する。
     */
    public function testUpdateCareer(): void
    {
        $careerEntity = new CareerEntity($this->career);
        $this->careerRepository->createCareer($careerEntity);

        $career = $this->career;
        $career['startDate'] = '2021/07/06';
        $career['finishDate'] = '2021/07/07';
        $career['overview'] = '更新用の概要。';
        $career['explainText'] = '更新用の説明。';

        $updateCareer = new CareerEntity($career);
        $this->careerRepository->updateCareer($updateCareer);
        $dbUpdateCareerEntity = $this->careerRepository->readCareerFromId($career['id']);

        $this->assertSame($dbUpdateCareerEntity->getId(), (string)$career['id']);
        $this->assertSame($dbUpdateCareerEntity->getUserId(), $career['userId']);
        $this->assertSame($dbUpdateCareerEntity->getStartDate(), str_replace('/', '-', $career['startDate']));
        $this->assertSame($dbUpdateCareerEntity->getFinishDate(), str_replace('/', '-', $career['finishDate']));
        $this->assertSame($dbUpdateCareerEntity->getOverview(), $career['overview']);
        $this->assertSame($dbUpdateCareerEntity->getExplainText(), $career['explainText']);
    }

    /**
     * 経歴エンティティをDBから削除する。
     */
    public function testDeleteCareer(): void
    {
        $careerEntity = new CareerEntity($this->career);
        $this->careerRepository->createCareer($careerEntity);

        $errorCode = $this->careerRepository->deleteCareer($careerEntity);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }
}
