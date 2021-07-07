<?php

/**
 * 経歴アプリケーションの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Application/CareerApplication.php');
require_once(dirname(__FILE__) . '/../Application/UserApplication.php');

class TestCareerApplication extends TestCase
{
    const SUCCESS_CODE = '00000'; // リポジトリから返される成功時のステータスコード。

    private int $id = 101; // 経歴ID
    private int $userId = 1001; // ユーザーID
    private string $startDate = '2021/07/05'; // 開始日
    private string $finishDate = '2021/07/06'; // 終了日
    private string $overview = '概要'; // 概要
    private string $explainText = '説明'; // 説明
    private array $career; // 経歴エンティティの作成に使用する配列

    private CareerApplication $careerApplication; // 経歴アプリケーション
    private UserApplication $userApplication; // ユーザーアプリケーション

    /**
     * 経歴作成用の配列を用意する。
     * 経歴アプリケーションを作成する。
     * 経歴作成の外部キー制約を回避するため、ユーザーを作成する。
     */
    public function setUp(): void
    {
        // 経歴作成用の配列を用意する。
        $this->career = [
            'id' => $this->id,
            'userId' => $this->userId,
            'startDate' => $this->startDate,
            'finishDate' => $this->finishDate,
            'overview' => $this->overview,
            'explainText' => $this->explainText
        ];

        // 経歴アプリケーションを作成する。
        $this->careerApplication = new CareerApplication();

        // 経歴作成の外部キー制約を回避するため、ユーザーを作成する。
        $this->userApplication = new UserApplication();
        $this->userApplication->createUser(['id' => $this->userId]);
    }

    /**
     * ユーザーを削除する。
     */
    public function tearDown(): void
    {
        $this->userApplication->deleteUser(['id' => $this->userId]);
    }

    /**
     * 経歴を作成する。
     */
    public function testCreateCareer(): void
    {
        $errorCode = $this->careerApplication->createCareer($this->career);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * ユーザーIDから経歴を取得する。
     */
    public function testReadCareerFromUserId(): void
    {
        $this->careerApplication->createCareer($this->career);
        $careers = $this->careerApplication->readCareerFromUserId($this->career['userId']);

        $this->assertFalse(empty($careers));
    }

    /**
     * 全ての経歴を取得する。
     */
    public function testReadAllCareer(): void
    {
        $this->careerApplication->createCareer($this->career);
        $careers = $this->careerApplication->readAllCareer();

        $this->assertFalse(empty($careers));
    }

    /**
     * 経歴を更新する。
     */
    public function testUpdateCareer(): void
    {
        $this->careerApplication->createCareer($this->career);

        $career = $this->career;
        $career['startDate'] = '2021/07/07';
        $career['finishDate'] = '2021/07/08';
        $career['overview'] = '更新用の概要';
        $career['explainText'] = '更新用の説明';
        $errorCode = $this->careerApplication->updateCareer($career);

        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * 経歴を削除する。
     */
    public function testDeleteCareer(): void
    {
        $errorCode = $this->careerApplication->deleteCareer($this->career);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }
}
