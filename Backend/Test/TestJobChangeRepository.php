<?php

/**
 * 転職事由の振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Repository/MysqlRepository.php');
require_once(dirname(__FILE__) . '/../Repository/JobChangeRepository.php');
require_once(dirname(__FILE__) . '/../Domain/JobChangeEntity.php');
require_once(dirname(__FILE__) . '/../Repository/UserRepository.php');
require_once(dirname(__FILE__) . '/../Domain/UserEntity.php');

class TestJobChangeRepository extends TestCase
{
    const SUCCESS_CODE = '00000'; // リポジトリから返される成功時のステータスコード。

    private int $id = 100; // 転職ID
    private int $userId = 1000; // ユーザーID
    private string $reason = '転職理由。'; // 転職理由
    private string $motivation = '志望動機。'; // 志望動機
    private string $experience = '活かせる経験。'; // 活かせる経験
    private array $jobChange; // 転職事由作成用の配列

    private JobChangeRepository $jobChangeRepository; // 転職事由のリポジトリ
    private UserRepository $userRepository; // ユーザーのリポジトリ

    /**
     * 転職事由エンティティ作成用の配列を用意する。
     * 転職事由のリポジトリを用意する。
     * ユーザーを作成する。
     */
    public function setUp(): void
    {
        // 転職事由エンティティ作成用の配列を用意する。
        $this->jobChange = [
            'id' => $this->id,
            'userId' => $this->userId,
            'reason' => $this->reason,
            'motivation' => $this->motivation,
            'experience' => $this->experience
        ];

        // 転職事由のリポジトリを用意する。
        $mysql = new Mysql();
        $this->jobChangeRepository = new JobChangeRepository($mysql->getPdo());

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
     * 転職事由エンティティを作成し、DBに登録する。
     */
    public function testCreateJobChange(): void
    {
        $jobChangeEntity = new JobChangeEntity($this->jobChange);
        $errorCode = $this->jobChangeRepository->createJobChange($jobChangeEntity);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * IDが空の転職事由エンティティを作成し、DBに登録する。
     */
    public function testCreateEmptyIdJobChange(): void
    {
        $jobChange = $this->jobChange;
        $jobChange['id'] = '';
        $jobChangeEntity = new JobChangeEntity($jobChange);
        $errorCode = $this->jobChangeRepository->createJobChange($jobChangeEntity);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * IDから転職事由エンティティを取得する。
     */
    public function testReadJobChangeFromId(): void
    {
        $jobChangeEntity = new JobChangeEntity($this->jobChange);
        $this->jobChangeRepository->createJobChange($jobChangeEntity);
        $dbJobChangeEntity = $this->jobChangeRepository->readJobChangeFromUserId($this->jobChange['userId']);

        $this->assertSame($dbJobChangeEntity->getId(), (string)$this->jobChange['id']);
    }

    /**
     * 全ての転職事由エンティティを取得する。
     */
    public function testReadAllJobChange(): void
    {
        $jobChangeEntity = new JobChangeEntity($this->jobChange);
        $this->jobChangeRepository->createJobChange($jobChangeEntity);
        $jobChanges = $this->jobChangeRepository->readAllJobChange();

        $this->assertFalse(empty($jobChanges));
    }

    /**
     * 転職事由エンティティをDBから削除する。
     */
    public function testDeleteJobChange(): void
    {
        $jobChangeEntity = new JobChangeEntity($this->jobChange);
        $this->jobChangeRepository->createJobChange($jobChangeEntity);

        $errorCode = $this->jobChangeRepository->deleteJobChange($jobChangeEntity);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }
}
