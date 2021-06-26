<?php

/**
 * ユーザーリポジトリの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Repository/MysqlRepository.php');
require_once(dirname(__FILE__) . '/../Repository/UserRepository.php');
require_once(dirname(__FILE__) . '/../Domain/UserEntity.php');

class TestUserRepository extends TestCase
{
    private int $id = 100;
    private string $name = 'test_user';
    private string $mail = 'test@gmail.com';
    private string $password = 'test@gmail.com';
    private string $picture = 'test.jpg';
    private string $birthday = '2021/6/26';
    private string $gender = '男';
    private string $background = 'テスト用の経歴。';
    private string $qualification = 'テスト用の資格。';
    private string $profile = 'テスト用のプロフィール。';
    private array $user;

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
     * ユーザーエンティティを作成し、DBに登録する。
     */
    public function testUserRepositoryCreateUserEntity()
    {
        $mysql = new Mysql();
        $userEntity = new UserEntity($this->user);
        $userRepository = new UserRepository($mysql->getPdo());
        $errorCode = $userRepository->create($userEntity);

        $this->assertSame($errorCode, '00000');
    }
}
