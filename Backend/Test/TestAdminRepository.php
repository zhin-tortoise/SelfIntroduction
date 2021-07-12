<?php

/**
 * 管理者の振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Repository/MysqlRepository.php');
require_once(dirname(__FILE__) . '/../Repository/AdminRepository.php');
require_once(dirname(__FILE__) . '/../Domain/AdminEntity.php');

class TestAdminRepository extends TestCase
{
    const SUCCESS_CODE = '00000'; // リポジトリから返される成功時のステータスコード。

    private int $id = 100; // 管理者ID
    private string $mail = 'test@gmail.com'; // メールアドレス
    private string $password = 'test'; // パスワード
    private array $admin; // 管理者エンティティ作成用の配列

    private AdminRepository $adminRepository; // 管理者のリポジトリ

    /**
     * 管理者エンティティ作成用の配列を用意する。
     * 管理者のリポジトリを用意する。
     */
    public function setUp(): void
    {
        // 管理者エンティティ作成用の配列を用意する。
        $this->admin = [
            'id' => $this->id,
            'mail' => $this->mail,
            'password' => $this->password
        ];

        // 管理者のリポジトリを用意する。
        $mysql = new Mysql();
        $this->adminRepository = new AdminRepository($mysql->getPdo());
    }

    /**
     * 管理者エンティティを作成し、DBに登録する。
     */
    public function testCreateAdmin(): void
    {
        $adminEntity = new AdminEntity($this->admin);
        $errorCode = $this->adminRepository->createAdmin($adminEntity);

        $this->assertSame($errorCode, self::SUCCESS_CODE);

        $this->adminRepository->deleteAdmin($adminEntity);
    }

    /**
     * メールアドレスから管理者エンティティを取得する。
     */
    public function testReadAdminFromMail(): void
    {
        $adminEntity = new AdminEntity($this->admin);
        $this->adminRepository->createAdmin($adminEntity);
        $dbAdminEntity = $this->adminRepository->readAdminFromMail($this->admin['mail']);

        $this->assertSame($dbAdminEntity->getId(), (string)$this->admin['id']);
    }

    /**
     * 管理者エンティティを更新する。
     */
    public function testUpdateAdmin(): void
    {
        $adminEntity = new AdminEntity($this->admin);
        $this->adminRepository->createAdmin($adminEntity);

        $admin = $this->admin;
        $admin['mail'] = 'update@gmail.com';
        $admin['password'] = '$2a$08$NDL7bvS5llgksICHNQEmneCi68hw4hW320tXZMfFbG3F9YXL6yQPi';

        $updateAdmin = new AdminEntity($admin);
        $this->adminRepository->updateAdmin($updateAdmin);
        $dbUpdateAdminEntity = $this->adminRepository->readAdminFromMail($admin['mail']);

        $this->assertSame($dbUpdateAdminEntity->getId(), (string)$admin['id']);
        $this->assertSame($dbUpdateAdminEntity->getMail(), $admin['mail']);
        $this->assertSame($dbUpdateAdminEntity->getPassword(), $admin['password']);
    }

    /**
     * 管理者エンティティをDBから削除する。
     */
    public function testDeleteAdmin(): void
    {
        $adminEntity = new AdminEntity($this->admin);
        $this->adminRepository->createAdmin($adminEntity);

        $errorCode = $this->adminRepository->deleteAdmin($adminEntity);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }
}
