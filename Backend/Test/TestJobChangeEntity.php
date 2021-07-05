<?php

/**
 * 転職事由エンティティの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Domain/JobChangeEntity.php');

class TestJobChangeEntity extends TestCase
{
    private $id = 1;
    private int $userId = 1;
    private string $reason = '転職理由。';
    private string $motivation = '志望動機。';
    private string $experience = '活かせる経験。';
    private array $jobChange;

    /**
     * 転職事由エンティティ作成用の配列を用意する。
     */
    public function setUp(): void
    {
        $this->jobChange = [
            'id' => $this->id,
            'userId' => $this->userId,
            'reason' => $this->reason,
            'motivation' => $this->motivation,
            'experience' => $this->experience
        ];
    }

    /**
     * 転職事由エンティティを作成する。
     */
    public function testCreateJobChangeEntity(): void
    {
        $jobChangeEntity = new JobChangeEntity($this->jobChange);

        $this->assertSame($jobChangeEntity->getId(), $this->id);
        $this->assertSame($jobChangeEntity->getUserId(), $this->userId);
        $this->assertSame($jobChangeEntity->getReason(), $this->reason);
        $this->assertSame($jobChangeEntity->getMotivation(), $this->motivation);
        $this->assertSame($jobChangeEntity->getExperience(), $this->experience);
    }

    /**
     * 空のデータで転職事由エンティティを作成する。
     */
    public function testCreateEmptyJobChangeEntity(): void
    {
        $jobChangeEntity = new JobChangeEntity([]);

        $this->assertSame($jobChangeEntity->getId(), null);
        $this->assertSame($jobChangeEntity->getUserId(), 0);
        $this->assertSame($jobChangeEntity->getReason(), '');
        $this->assertSame($jobChangeEntity->getMotivation(), '');
        $this->assertSame($jobChangeEntity->getExperience(), '');
    }

    /**
     * IDが空の転職事由エンティティを作成する。
     */
    public function testCreateEmptyIdJobChange(): void
    {
        $jobChange = $this->jobChange;
        $jobChange['id'] = '';
        $jobChangeEntity = new JobChangeEntity($jobChange);

        $this->assertNull($jobChangeEntity->getId());
    }
}
