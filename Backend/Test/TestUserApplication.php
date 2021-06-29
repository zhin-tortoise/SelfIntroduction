<?php

/**
 * ユーザーアプリケーションの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Application/UserApplication.php');
require_once(dirname(__FILE__) . '/../Repository/MysqlRepository.php');
require_once(dirname(__FILE__) . '/../Repository/UserRepository.php');

class TestUserApplication extends TestCase
{
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
    }

    /**
     * ユーザーを作成する。
     */
    public function testCreateUser(): void
    {
        $userApplication = new UserApplication();
        $errorCode = $userApplication->createUser($this->user);

        $this->assertSame($errorCode, '00000');

        $userApplication->deleteUser($this->user);
    }

    /**
     * 空のデータでユーザーを作成する。
     */
    public function testCreateEmptyUser(): void
    {
        $userApplication = new UserApplication();
        $errorCode = $userApplication->createUser([]);

        $this->assertSame($errorCode, '00000');

        $mysql = new Mysql();
        $userRepository = new UserRepository($mysql->getPdo());
        $userRepository->deleteMaxIDUser();
    }

    /**
     * パスワードがbcryptでないユーザーを作成する。
     * パスワードがbcryptで登録されていることを確認する。
     */
    public function testCreateNotBcryptPasswordUser(): void
    {
        $user = $this->user;
        $user['password'] = 'password';

        $userApplication = new UserApplication();
        $userApplication->createUser($user);

        $userEntity = $userApplication->readUserFromID($user['id']);
        $this->assertTrue(password_verify('password', $userEntity->getPassword()));

        $userApplication->deleteUser($this->user);
    }

    /**
     * IDからユーザーを取得する。
     */
    public function testReadUserFromID(): void
    {
        $userApplication = new UserApplication();
        $userApplication->createUser($this->user);
        $userEntity = $userApplication->readUserFromID($this->user['id']);

        $this->assertSame($userEntity->getID(), (string)$this->user['id']);

        $userApplication->deleteUser($this->user);
    }

    /**
     * メールアドレスからユーザーを取得する。
     */
    public function testReadUserFromMail(): void
    {
        $userApplication = new UserApplication();
        $userApplication->createUser($this->user);
        $userEntity = $userApplication->readUserFromMail($this->user['mail']);

        $this->assertSame($userEntity->getID(), (string)$this->user['id']);

        $userApplication->deleteUser($this->user);
    }

    /**
     * 全てのユーザーを取得する。
     */
    public function testReadAllUser(): void
    {
        $userApplication = new UserApplication();
        $userApplication->createUser($this->user);
        $userEntities = $userApplication->readAllUser();

        $this->assertFalse(empty($userEntities));

        $userApplication->deleteUser($this->user);
    }

    /**
     * ユーザーを更新する。
     */
    public function testUpdateUser(): void
    {
        $userApplication = new UserApplication();
        $userApplication->createUser($this->user);

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
        $errorCode = $userApplication->updateUser($user);

        $this->assertSame($errorCode, '00000');
    }

    /**
     * ユーザーを削除する。
     */
    public function testDeleteUser(): void
    {
        $userApplication = new UserApplication();
        $userApplication->createUser($this->user);
        $errorCode = $userApplication->deleteUser($this->user);

        $this->assertSame($errorCode, '00000');
    }
}
