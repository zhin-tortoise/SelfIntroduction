<?php

/**
 * 経歴エンティティの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Domain/CareerEntity.php');

class TestCareerEntity extends TestCase
{
    private int $id = 100; // 経歴ID
    private int $userId = 1000; // ユーザーID
    private string $startDate = '2021/07/05'; // 開始日
    private string $finishDate = '2021/07/06'; // 終了日
    private string $overview = '経歴の概要。'; // 概要
    private string $explainText = '経歴の中身。'; // 説明
    private array $career; // 経歴エンティティ作成用の配列

    /**
     * 経歴エンティティ作成用の配列を用意する。
     */
    public function setUp(): void
    {
        $this->career = [
            'id' => $this->id,
            'userId' => $this->userId,
            'startDate' => $this->startDate,
            'finishDate' => $this->finishDate,
            'overview' => $this->overview,
            'explainText' => $this->explainText
        ];
    }

    /**
     * 経歴エンティティを作成する。
     */
    public function testCreateCareerEntity(): void
    {
        $careerEntity = new CareerEntity($this->career);

        $this->assertSame($careerEntity->getId(), $this->id);
        $this->assertSame($careerEntity->getUserId(), $this->userId);
        $this->assertSame($careerEntity->getStartDate(), $this->startDate);
        $this->assertSame($careerEntity->getFinishDate(), $this->finishDate);
        $this->assertSame($careerEntity->getOverview(), $this->overview);
        $this->assertSame($careerEntity->getExplainText(), $this->explainText);
    }

    /**
     * 空のデータで経歴エンティティを作成する。
     */
    public function testCreateEmptyCareerEntity(): void
    {
        $careerEntity = new CareerEntity([]);

        $this->assertSame($careerEntity->getId(), null);
        $this->assertSame($careerEntity->getUserId(), 0);
        $this->assertSame($careerEntity->getStartDate(), null);
        $this->assertSame($careerEntity->getFinishDate(), null);
        $this->assertSame($careerEntity->getOverview(), '');
        $this->assertSame($careerEntity->getExplainText(), '');
    }

    /**
     * IDが空の経歴エンティティを作成する。
     */
    public function testCreateEmptyIdCareer(): void
    {
        $career = $this->career;
        $career['id'] = '';
        $careerEntity = new CareerEntity($career);

        $this->assertNull($careerEntity->getId());
    }

    /**
     * 開始日が空の経歴エンティティを作成する。
     */
    public function testCreateEmptyStartDateCareer(): void
    {
        $career = $this->career;
        $career['startDate'] = '';
        $careerEntity = new CareerEntity($career);

        $this->assertNull($careerEntity->getStartDate());
    }

    /**
     * 終了日が空の経歴エンティティを作成する。
     */
    public function testCreateEmptyFinishDateCareer(): void
    {
        $career = $this->career;
        $career['finishDate'] = '';
        $careerEntity = new CareerEntity($career);

        $this->assertNull($careerEntity->getFinishDate());
    }
}
