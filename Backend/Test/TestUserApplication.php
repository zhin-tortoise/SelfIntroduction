<?php

/**
 * ユーザーアプリケーションの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Application/UserApplication.php');

class TestUserApplication extends TestCase
{
    const SUCCESS_CODE = '00000';

    private int $id = 100; // ユーザーID
    private string $name = 'testUser'; // ユーザー名
    private string $mail = 'testUser@gmail.com'; // メールアドレス
    private string $password = '$2y$10$vfhAWUmdUsIcDzXcP9GGgOGEI0KJ.5DlJnSFJb9dNOtheqNUTqTgy'; // パスワード
    private string $picture = 'test.jpg'; // 写真
    private string $birthday = '2021/6/26'; // 誕生日
    private string $gender = '男'; // 性別
    private string $background = 'テスト用の経歴。'; // 経歴
    private string $qualification = 'テスト用の資格。'; // 資格
    private string $profile = 'テスト用のプロフィール。'; // プロフィール
    private array $user; // ユーザーエンティティの作成に使用する配列。

    private UserApplication $userApplication;

    /**
     * ユーザーエンティティ作成用の配列を用意する。
     */
    public function setUp(): void
    {
        $this->user = [
            'id' => $this->id,
            'name' => $this->name,
            'mail' => $this->mail,
            'password' => $this->password,
            'picture' => $this->picture,
            'birthday' => $this->birthday,
            'gender' => $this->gender,
            'background' => $this->background,
            'qualification' => $this->qualification,
            'profile' => $this->profile
        ];

        $this->userApplication = new UserApplication();
    }

    /**
     * ユーザーを作成する。
     */
    public function testCreateUser(): void
    {
        $errorCode = $this->userApplication->createUser($this->user);
        $this->assertSame($errorCode, self::SUCCESS_CODE);

        $this->userApplication->deleteUser($this->user);
    }

    /**
     * 空のデータでユーザーを作成する。
     */
    public function testCreateEmptyUser(): void
    {
        $errorCode = $this->userApplication->createUser([]);
        $this->assertSame($errorCode, self::SUCCESS_CODE);

        $this->userApplication->deleteMaxIdUser();
    }

    /**
     * パスワードがbcryptでないユーザーを作成する。
     * パスワードがbcryptで登録されていることを確認する。
     */
    public function testCreateNotBcryptPasswordUser(): void
    {
        $user = $this->user;
        $user['password'] = 'password';
        $this->userApplication->createUser($user);

        $userEntity = $this->userApplication->readUserFromID($user['id']);
        $this->assertTrue(password_verify('password', $userEntity->getPassword()));

        $this->userApplication->deleteUser($this->user);
    }

    /**
     * IDからユーザーを取得する。
     */
    public function testReadUserFromID(): void
    {
        $this->userApplication->createUser($this->user);
        $userEntity = $this->userApplication->readUserFromID($this->user['id']);

        $this->assertSame($userEntity->getId(), (string)$this->user['id']);

        $this->userApplication->deleteUser($this->user);
    }

    /**
     * メールアドレスからユーザーを取得する。
     */
    public function testReadUserFromMail(): void
    {
        $this->userApplication->createUser($this->user);
        $userEntity = $this->userApplication->readUserFromMail($this->user['mail']);

        $this->assertSame($userEntity->getId(), (string)$this->user['id']);

        $this->userApplication->deleteUser($this->user);
    }

    /**
     * 全てのユーザーを取得する。
     */
    public function testReadAllUser(): void
    {
        $this->userApplication->createUser($this->user);
        $userEntities = $this->userApplication->readAllUser();

        $this->assertFalse(empty($userEntities));

        $this->userApplication->deleteUser($this->user);
    }

    /**
     * ユーザーを更新する。
     */
    public function testUpdateUser(): void
    {
        $this->userApplication->createUser($this->user);

        $user = $this->user;
        $user['name'] = 'updateUser';
        $user['mail'] = 'updateUser@gmail.com';
        $user['password'] = '$2a$08$NDL7bvS5llgksICHNQEmneCi68hw4hW320tXZMfFbG3F9YXL6yQPi';
        $user['picture'] = 'update.jpg';
        $user['birthday'] = '2021/06/29';
        $user['gender'] = '女';
        $user['background'] = '更新用の経歴。';
        $user['qualification'] = '更新用の資格。';
        $user['profile'] = '更新用のプロフィール。';
        $errorCode = $this->userApplication->updateUser($user);

        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * ユーザーを削除する。
     */
    public function testDeleteUser(): void
    {
        $this->userApplication->createUser($this->user);
        $errorCode = $this->userApplication->deleteUser($this->user);

        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * IDが最大のユーザーを削除する。
     */
    public function testDeleteMaxIDUser(): void
    {
        $this->userApplication->createUser([]);

        $errorCode = $this->userApplication->deleteMaxIdUser();
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }
}
