<?php

/**
 * 転職事由アプリケーションの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Application/JobChangeApplication.php');
require_once(dirname(__FILE__) . '/../Application/UserApplication.php');

class TestJobChangeApplication extends TestCase
{
    const SUCCESS_CODE = '00000'; // リポジトリから返される成功時のステータスコード。

    private int $id = 101; // 転職ID
    private int $userId = 1001; // ユーザーID
    private string $reason = '転職理由。'; // 転職理由
    private string $motivation = '志望動機。'; // 志望動機
    private string $experience  = '活かせる経験。'; // 活かせる経験
    private array $jobChange; // 転職事由エンティティの作成に使用する配列。

    private JobChangeApplication $jobChangeApplication; // 転職事由アプリケーション
    private UserApplication $userApplication; // ユーザーアプリケーション

    /**
     * 転職事由作成用の配列を用意する。
     * 転職事由アプリケーションを作成する。
     * 転職事由作成の外部キー制約を回避するため、ユーザーを作成する。
     */
    public function setUp(): void
    {
        // 転職事由作成用の配列を用意する。
        $this->jobChange = [
            'id' => $this->id,
            'userId' => $this->userId,
            'reason' => $this->reason,
            'motivation' => $this->motivation,
            'experience' => $this->experience
        ];

        // 転職事由アプリケーションを作成する。
        $this->jobChangeApplication = new JobChangeApplication();

        // 転職事由作成の外部キー制約を回避するため、ユーザーを作成する。
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
     * 転職事由を作成する。
     */
    public function testCreateJobChange(): void
    {
        $errorCode = $this->jobChangeApplication->createJobChange($this->jobChange);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * IDから転職事由を取得する。
     */
    public function testReadJobChangeFromId(): void
    {
        $this->jobChangeApplication->createJobChange($this->jobChange);
        $jobChangeEntity = $this->jobChangeApplication->readJobChangeFromUserId($this->jobChange['userId']);

        $this->assertSame($jobChangeEntity->getId(), (string)$this->jobChange['id']);
    }

    /**
     * 全ての転職事由を取得する。
     */
    public function testReadAllJobChange(): void
    {
        $this->jobChangeApplication->createJobChange($this->jobChange);
        $jobChanges = $this->jobChangeApplication->readAllJobChange();

        $this->assertFalse(empty($jobChanges));
    }

    /**
     * 転職事由を更新する。
     */
    public function testUpdateJobChange(): void
    {
        $this->jobChangeApplication->createJobChange($this->jobChange);

        $jobChange = $this->jobChange;
        $jobChange['reason'] = '更新用の転職理由。';
        $jobChange['motivation'] = '更新用の志望動機。';
        $jobChange['experience'] = '更新用の活かせる経験。';
        $errorCode = $this->jobChangeApplication->updateJobChange($jobChange);

        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * 転職事由を削除する。
     */
    public function testDeleteJobChange(): void
    {
        $errorCode = $this->jobChangeApplication->deleteJobChange($this->jobChange);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }
}
