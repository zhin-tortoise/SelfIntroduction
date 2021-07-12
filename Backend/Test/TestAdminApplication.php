<?php

/**
 * 管理者アプリケーションの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Application/AdminApplication.php');

class TestAdminApplication extends TestCase
{
    const SUCCESS_CODE = '00000'; // リポジトリから返される成功時のステータスコード。

    private int $id = 100; // 管理者ID
    private string $mail = 'test@gmail.com'; // メールアドレス
    private string $password = 'test'; // パスワード
    private array $admin; // 管理者エンティティ作成用の配列

    private AdminApplication $adminApplication; // 管理者アプリケーション

    /**
     * 管理者作成用の配列を用意する。
     * 管理者アプリケーションを作成する。
     */
    public function setUp(): void
    {
        // 管理者作成用の配列を用意する。
        $this->admin = [
            'id' => $this->id,
            'mail' => $this->mail,
            'password' => $this->password
        ];

        // 管理者アプリケーションを作成する。
        $this->adminApplication = new AdminApplication();
    }

    /**
     * 管理者を作成する。
     */
    public function testCreateAdmin(): void
    {
        $errorCode = $this->adminApplication->createAdmin($this->admin);
        $this->assertSame($errorCode, self::SUCCESS_CODE);

        $this->adminApplication->deleteAdmin($this->admin);
    }

    /**
     * メールアドレスから管理者を取得する。
     */
    public function testReadAdminFromMail(): void
    {
        $this->adminApplication->createAdmin($this->admin);
        $adminEntity = $this->adminApplication->readAdminFromMail($this->admin['mail']);

        $this->assertSame($adminEntity->getId(), (string)$this->id);

        $this->adminApplication->deleteAdmin($this->admin);
    }

    /**
     * 管理者を更新する。
     */
    public function testUpdateAdmin(): void
    {
        $this->adminApplication->createAdmin($this->admin);

        $admin = $this->admin;
        $admin['mail'] = 'update@mail.com';
        $admin['password'] = 'update';
        $errorCode = $this->adminApplication->updateAdmin($this->admin);

        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * 管理者を削除する。
     */
    public function testDeleteAdmin(): void
    {
        $this->adminApplication->createAdmin($this->admin);
        $errorCode = $this->adminApplication->deleteAdmin($this->admin);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }
}
