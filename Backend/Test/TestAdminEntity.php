<?php

/**
 * 管理者エンティティの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Domain/AdminEntity.php');

class TestAdminEntity extends TestCase
{
    private int $id = 100; // 管理者ID
    private string $mail = 'test@gmail.com'; // メールアドレス
    private string $password = '$2y$10$vfhAWUmdUsIcDzXcP9GGgOGEI0KJ.5DlJnSFJb9dNOtheqNUTqTgy'; // パスワード
    private array $admin; // 管理者エンティティ作成用の配列

    /**
     * 管理者エンティティ作成用の配列を用意する。
     */
    public function setUp(): void
    {
        $this->admin = [
            'id' => $this->id,
            'mail' => $this->mail,
            'password' => $this->password
        ];
    }

    /**
     * 管理者エンティティを作成する。
     */
    public function testCreateAdminEntity(): void
    {
        $adminEntity = new AdminEntity($this->admin);

        $this->assertSame($adminEntity->getId(), $this->id);
        $this->assertSame($adminEntity->getMail(), $this->mail);
        $this->assertSame($adminEntity->getPassword(), $this->password);
    }

    /**
     * 空のデータで管理者エンティティを作成する。
     */
    public function testCreateEmptyAdminEntity(): void
    {
        $adminEntity = new AdminEntity([]);

        $this->assertSame($adminEntity->getId(), null);
        $this->assertSame($adminEntity->getMail(), '');
        $this->assertSame($adminEntity->getPassword(), '');
    }

    /**
     * IDが空の管理者エンティティを作成する。
     */
    public function testCreateEmptyIdAdmin(): void
    {
        $admin = $this->admin;
        $admin['id'] = '';
        $adminEntity = new AdminEntity($admin);

        $this->assertNull($adminEntity->getId());
    }

    /**
     * パスワードがbcryptハッシュでないならハッシュに変換する。
     */
    public function testPasswordToBcrypt(): void
    {
        $admin = $this->admin;
        $admin['password'] = 'password';
        $adminEntity = new AdminEntity($admin);

        $this->assertTrue(password_verify('password', $adminEntity->getPassword()));
    }
}
