<?php

/**
 * ユーザーアプリケーションの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Application/UserApplication.php');

class TestUserApplication extends TestCase
{
    /**
     * ユーザーを作成する。
     */
    public function testCreateUser()
    {
        $id = 101;
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

        $userApplication = new UserApplication();
        $error_code = $userApplication->create($user);

        $this->assertSame($error_code, '00000');
    }
}
