<?php

/**
 * ユーザーエンティティの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Domain/UserEntity.php');


class TestUserEntity extends TestCase
{
    /**
     * ユーザーエンティティを作成する。
     */
    public function testCreateUserEntity(): void
    {
        $id = 1;
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

        $userEntity = new UserEntity($user);

        $this->assertSame($userEntity->getID(), $id);
        $this->assertSame($userEntity->getName(), $name);
        $this->assertSame($userEntity->getMail(), $mail);
        $this->assertSame($userEntity->getPassword(), $password);
        $this->assertSame($userEntity->getPicture(), $picture);
        $this->assertSame($userEntity->getBirthday(), $birthday);
        $this->assertSame($userEntity->getGender(), $gender);
        $this->assertSame($userEntity->getBackground(), $background);
        $this->assertSame($userEntity->getQualification(), $qualification);
        $this->assertSame($userEntity->getProfile(), $profile);
    }
}
