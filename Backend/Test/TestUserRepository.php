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
    /**
     * ユーザーエンティティを引数で取得し、
     * 与えられたユーザーエンティティをDBに登録する。
     */
    public function testUserRepositoryCreateUserEntity()
    {
        $id = 100;
        $name = 'test_user';
        $mail = 'test@gmail.com';
        $password = 'test@gmail.com';
        $picture = 'test.jpg';
        $birthday = '2021/6/26';
        $gender = '男';
        $background = 'テスト用の経歴。';
        $qualification = 'テスト用の資格。';
        $profile = 'テスト用のプロフィール。';

        $user = [
            'id' => $id,
            'name' => $name,
            'mail' => $mail,
            'password' => $password,
            'picture' => $picture,
            'birthday' => $birthday,
            'gender' => $gender,
            'background' => $background,
            'qualification' => $qualification,
            'profile' => $profile
        ];

        $mysql = new Mysql();
        $userEntity = new UserEntity($user);
        $userRepository = new UserRepository($mysql->getPdo());
        $errorCode = $userRepository->create($userEntity);

        $this->assertSame($errorCode, '00000');
    }
}
