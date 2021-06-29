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
    private array $user; // ユーザーエンティティ作成用の配列

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
     * ユーザーエンティティを作成し、DBに登録する。
     */
    public function testCreateUser(): void
    {
        $mysql = new Mysql();
        $userEntity = new UserEntity($this->user);
        $userRepository = new UserRepository($mysql->getPdo());

        $errorCode = $userRepository->create($userEntity);
        $this->assertSame($errorCode, '00000');

        $userRepository->delete($userEntity);
    }

    /**
     * 同一のIDのユーザーエンティティを複数作成し、DBに登録する。
     */
    public function testCreateSameIDUser(): void
    {
        $mysql = new Mysql();
        $userEntity = new UserEntity($this->user);
        $userRepository = new UserRepository($mysql->getPdo());

        $errorCode = $userRepository->create($userEntity);
        $this->assertSame($errorCode, '00000');

        $sameIDUser = $this->user;
        $sameIDUser['mail'] = 'sameIDUser@gmail.com'; // 同一のメールアドレスだと弾かれるため変更する。
        $sameIDUserEntity = new UserEntity($sameIDUser);

        $errorCode = $userRepository->create($sameIDUserEntity);
        $this->assertSame($errorCode, '23000');

        $userRepository->delete($userEntity);
    }

    /**
     * IDが空のユーザーエンティティを作成する。
     */
    public function testEmptyUser(): void
    {
        $user = $this->user;
        $user['id'] = '';

        $mysql = new Mysql();
        $userEntity = new UserEntity($user);
        $userRepository = new UserRepository($mysql->getPdo());

        $errorCode = $userRepository->create($userEntity);
        $this->assertSame($errorCode, '00000');

        $userRepository->deleteMaxIDUser();
    }

    /**
     * 同じメールアドレスのユーザーエンティティを作成しDBに登録する。
     */
    public function testCreateSameMailUser(): void
    {
        $mysql = new Mysql();
        $userEntity = new UserEntity($this->user);
        $userRepository = new UserRepository($mysql->getPdo());

        $errorCode = $userRepository->create($userEntity);
        $this->assertSame($errorCode, '00000');

        $errorCode = $userRepository->create($userEntity);
        $this->assertSame($errorCode, '99998');

        $userRepository->delete($userEntity);
    }

    /**
     * IDからユーザーエンティティを取得する。
     */
    public function testReadUserFromID(): void
    {
        $mysql = new Mysql();
        $userEntity = new UserEntity($this->user);
        $userRepository = new UserRepository($mysql->getPdo());

        $userRepository->create($userEntity);
        $dbUserEntity = $userRepository->readUserFromID($this->user['id']);

        $this->assertSame($dbUserEntity->getID(), (string)$this->user['id']);

        $userRepository->delete($userEntity);
    }

    /**
     * メールアドレスからユーザーエンティティを取得する。
     */
    public function testReadUserFromMail(): void
    {
        $mysql = new Mysql();
        $userEntity = new UserEntity($this->user);
        $userRepository = new UserRepository($mysql->getPdo());

        $userRepository->create($userEntity);
        $dbUserEntity = $userRepository->readUserFromMail($this->user['mail']);

        $this->assertSame($dbUserEntity->getID(), (string)$this->user['id']);

        $userRepository->delete($userEntity);
    }

    /**
     * 全てのユーザーエンティティを取得する。
     */
    public function testReadAllUser(): void
    {
        $mysql = new Mysql();
        $userEntity = new UserEntity($this->user);
        $userRepository = new UserRepository($mysql->getPdo());

        $userRepository->create($userEntity);
        $userEntities = $userRepository->readAllUser();

        $this->assertFalse(empty($userEntities));

        $userRepository->delete($userEntity);
    }

    /**
     * ユーザーエンティティを更新する。
     */
    public function testUpdateUser(): void
    {
        $mysql = new Mysql();
        $userEntity = new UserEntity($this->user);
        $userRepository = new UserRepository($mysql->getPdo());

        $userRepository->create($userEntity);

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

        $updateUserEntity = new UserEntity($user);
        $userRepository->updateUser($updateUserEntity);
        $dbUpdateUserEntity = $userRepository->readUserFromID($user['id']);

        $this->assertSame($dbUpdateUserEntity->getID(), (string)$user['id']);
        $this->assertSame($dbUpdateUserEntity->getName(), $user['name']);
        $this->assertSame($dbUpdateUserEntity->getMail(), $user['mail']);
        $this->assertSame($dbUpdateUserEntity->getPassword(), $user['password']);
        $this->assertSame($dbUpdateUserEntity->getPicture(), $user['picture']);
        $this->assertSame($dbUpdateUserEntity->getBirthday(), str_replace('/', '-', $user['birthday']));
        $this->assertSame($dbUpdateUserEntity->getGender(), $user['gender']);
        $this->assertSame($dbUpdateUserEntity->getBackground(), $user['background']);
        $this->assertSame($dbUpdateUserEntity->getQualification(), $user['qualification']);
        $this->assertSame($dbUpdateUserEntity->getProfile(), $user['profile']);

        $userRepository->delete($dbUpdateUserEntity);
    }

    /**
     * 存在しないユーザーエンティティを更新する。
     */
    public function testUpdateNotExistsUser(): void
    {
        $mysql = new Mysql();
        $userEntity = new UserEntity($this->user);
        $userRepository = new UserRepository($mysql->getPdo());

        $userRepository->create($userEntity);

        $updateUser = $this->user;
        $updateUser['id'] = 0;
        $updateUser['mail'] = 'update@gmail.com';
        $updateUserEntity = new UserEntity($updateUser);
        $errorCode = $userRepository->updateUser($updateUserEntity);

        $this->assertSame($errorCode, '00000');
    }

    /**
     * 自身のメールアドレス以外に既に存在するメールアドレスでユーザーエンティティを更新する。
     */
    public function testUpdateExistsMailUser(): void
    {
        $mysql = new Mysql();
        $userRepository = new UserRepository($mysql->getPdo());

        $firstUser = $this->user;
        $firstUserEntity = new UserEntity($firstUser);
        $userRepository->create($firstUserEntity);

        $secondUser = $this->user;
        $secondUser['id'] = $secondUser['id'] + 1;
        $secondUser['mail'] = 'second@gmail.com';
        $secondUserEntity = new UserEntity($secondUser);
        $userRepository->create($secondUserEntity);

        $firstUser['mail'] = 'second@gmail.com';
        $firstUserEntity = new UserEntity($firstUser);
        $errorCode = $userRepository->updateUser($firstUserEntity);

        $this->assertSame($errorCode, '99998');

        $userRepository->delete($firstUserEntity);
        $userRepository->delete($secondUserEntity);
    }

    /**
     * ユーザーエンティティをDBから削除する。
     */
    public function testDeleteUser(): void
    {
        $mysql = new Mysql();
        $userEntity = new UserEntity($this->user);
        $userRepository = new UserRepository($mysql->getPdo());

        $userRepository->create($userEntity);

        $errorCode = $userRepository->delete($userEntity);
        $this->assertSame($errorCode, '00000');
    }

    /**
     * IDが最大のユーザーを削除する。
     */
    public function testDeleteMaxIDUser(): void
    {
        $mysql = new Mysql();
        $userEntity = new UserEntity($this->user);
        $userRepository = new UserRepository($mysql->getPdo());

        $userRepository->create($userEntity);

        $errorCode = $userRepository->deleteMaxIDUser();
        $this->assertSame($errorCode, '00000');
    }
}
