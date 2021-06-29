<?php

/**
 * ユーザーエンティティの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Domain/UserEntity.php');


class TestUserEntity extends TestCase
{
    private int $id = 1; // ユーザーID
    private string $name = 'testUser'; // ユーザー名。
    private string $mail = 'testUser@gmail.com'; // メールアドレス
    private string $password = '$2y$10$vfhAWUmdUsIcDzXcP9GGgOGEI0KJ.5DlJnSFJb9dNOtheqNUTqTgy'; // パスワード
    private string $picture = 'test.jpg'; // 写真
    private string $birthday = '2021/6/26'; // 誕生日
    private string $gender = '男'; // 性別
    private string $background = 'テスト用の経歴。'; // 経歴
    private string $qualification = 'テスト用の資格。'; // 資格
    private string $profile = 'テスト用のプロフィール。'; // プロフィール
    private array $user;

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
     * ユーザーエンティティを作成する。
     */
    public function testCreateUserEntity(): void
    {
        $userEntity = new UserEntity($this->user);

        $this->assertSame($userEntity->getID(), $this->id);
        $this->assertSame($userEntity->getName(), $this->name);
        $this->assertSame($userEntity->getMail(), $this->mail);
        $this->assertSame($userEntity->getPassword(), $this->password);
        $this->assertSame($userEntity->getPicture(), $this->picture);
        $this->assertSame($userEntity->getBirthday(), $this->birthday);
        $this->assertSame($userEntity->getGender(), $this->gender);
        $this->assertSame($userEntity->getBackground(), $this->background);
        $this->assertSame($userEntity->getQualification(), $this->qualification);
        $this->assertSame($userEntity->getProfile(), $this->profile);
    }

    /**
     * 空のデータでユーザーエンティティを作成する。
     */
    public function testCreateEmptyUser(): void
    {
        $userEntity = new UserEntity([]);

        $this->assertSame($userEntity->getID(), null);
        $this->assertSame($userEntity->getName(), '');
        $this->assertSame($userEntity->getMail(), '');
        $this->assertSame($userEntity->getPassword(), '');
        $this->assertSame($userEntity->getPicture(), '');
        $this->assertSame($userEntity->getBirthday(), null);
        $this->assertSame($userEntity->getGender(), '');
        $this->assertSame($userEntity->getBackground(), '');
        $this->assertSame($userEntity->getQualification(), '');
        $this->assertSame($userEntity->getProfile(), '');
    }

    /**
     * IDが空のユーザーエンティティを作成する。
     */
    public function testCreateEmptyIDUser(): void
    {
        $user = $this->user;
        $user['id'] = '';
        $userEntity = new UserEntity($user);

        $this->assertNull($userEntity->getID());
    }

    /**
     * パスワードがbcryptハッシュでないならハッシュに変換する。
     */
    public function testPasswordToBcrypt()
    {
        $user = $this->user;
        $user['password'] = 'password';
        $userEntity = new UserEntity($user);

        $this->assertTrue(password_verify('password', $userEntity->getPassword()));
    }

    /**
     * 誕生日が空のユーザーエンティティを作成する。
     */
    public function testCreateEmptyBirthdayUser()
    {
        $user = $this->user;
        $user['birthday'] = '';
        $userEntity = new UserEntity($user);

        $this->assertNull($userEntity->getBirthday());
    }
}
