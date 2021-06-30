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
    const SUCCESS_CODE = '00000';
    const EXISTS_ID_CODE = '23000';
    const EXISTS_MAIL_CODE = '99998';

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

    private UserRepository $userRepository;

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

        $mysql = new Mysql();
        $this->userRepository = new UserRepository($mysql->getPdo());
    }

    /**
     * ユーザーエンティティを作成し、DBに登録する。
     */
    public function testCreateUser(): void
    {
        $userEntity = new UserEntity($this->user);
        $errorCode = $this->userRepository->createUser($userEntity);
        $this->assertSame($errorCode, self::SUCCESS_CODE);

        $this->userRepository->deleteUser($userEntity);
    }

    /**
     * 同一のIDのユーザーエンティティを複数作成し、DBに登録する。
     */
    public function testCreateSameIDUser(): void
    {
        $userEntity = new UserEntity($this->user);
        $this->userRepository->createUser($userEntity);

        $sameIDUser = $this->user;
        $sameIDUser['mail'] = 'sameIDUser@gmail.com'; // 同一のメールアドレスだと弾かれるため変更する。
        $sameIDUserEntity = new UserEntity($sameIDUser);

        $errorCode = $this->userRepository->createUser($sameIDUserEntity);
        $this->assertSame($errorCode, self::EXISTS_ID_CODE);

        $this->userRepository->deleteUser($userEntity);
    }

    /**
     * IDが空のユーザーエンティティを作成する。
     */
    public function testEmptyUser(): void
    {
        $user = $this->user;
        $user['id'] = '';
        $userEntity = new UserEntity($user);

        $errorCode = $this->userRepository->createUser($userEntity);
        $this->assertSame($errorCode, self::SUCCESS_CODE);

        $this->userRepository->deleteMaxIdUser();
    }

    /**
     * 同じメールアドレスのユーザーエンティティを作成しDBに登録する。
     */
    public function testCreateSameMailUser(): void
    {
        $userEntity = new UserEntity($this->user);
        $this->userRepository->createUser($userEntity);

        $errorCode = $this->userRepository->createUser($userEntity);
        $this->assertSame($errorCode, self::EXISTS_MAIL_CODE);

        $this->userRepository->deleteUser($userEntity);
    }

    /**
     * IDからユーザーエンティティを取得する。
     */
    public function testReadUserFromID(): void
    {
        $userEntity = new UserEntity($this->user);
        $this->userRepository->createUser($userEntity);
        $dbUserEntity = $this->userRepository->readUserFromID($this->user['id']);

        $this->assertSame($dbUserEntity->getId(), (string)$this->user['id']);

        $this->userRepository->deleteUser($userEntity);
    }

    /**
     * メールアドレスからユーザーエンティティを取得する。
     */
    public function testReadUserFromMail(): void
    {
        $userEntity = new UserEntity($this->user);
        $this->userRepository->createUser($userEntity);
        $dbUserEntity = $this->userRepository->readUserFromMail($this->user['mail']);

        $this->assertSame($dbUserEntity->getId(), (string)$this->user['id']);

        $this->userRepository->deleteUser($userEntity);
    }

    /**
     * 全てのユーザーエンティティを取得する。
     */
    public function testReadAllUser(): void
    {
        $userEntity = new UserEntity($this->user);
        $this->userRepository->createUser($userEntity);
        $userEntities = $this->userRepository->readAllUser();

        $this->assertFalse(empty($userEntities));

        $this->userRepository->deleteUser($userEntity);
    }

    /**
     * ユーザーエンティティを更新する。
     */
    public function testUpdateUser(): void
    {
        $userEntity = new UserEntity($this->user);
        $this->userRepository->createUser($userEntity);

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
        $this->userRepository->updateUser($updateUserEntity);
        $dbUpdateUserEntity = $this->userRepository->readUserFromID($user['id']);

        $this->assertSame($dbUpdateUserEntity->getId(), (string)$user['id']);
        $this->assertSame($dbUpdateUserEntity->getName(), $user['name']);
        $this->assertSame($dbUpdateUserEntity->getMail(), $user['mail']);
        $this->assertSame($dbUpdateUserEntity->getPassword(), $user['password']);
        $this->assertSame($dbUpdateUserEntity->getPicture(), $user['picture']);
        $this->assertSame($dbUpdateUserEntity->getBirthday(), str_replace('/', '-', $user['birthday']));
        $this->assertSame($dbUpdateUserEntity->getGender(), $user['gender']);
        $this->assertSame($dbUpdateUserEntity->getBackground(), $user['background']);
        $this->assertSame($dbUpdateUserEntity->getQualification(), $user['qualification']);
        $this->assertSame($dbUpdateUserEntity->getProfile(), $user['profile']);

        $this->userRepository->deleteUser($dbUpdateUserEntity);
    }

    /**
     * 存在しないユーザーエンティティを更新する。
     */
    public function testUpdateNotExistsUser(): void
    {
        $userEntity = new UserEntity($this->user);
        $this->userRepository->createUser($userEntity);

        $updateUser = $this->user;
        $updateUser['id'] = 0;
        $updateUser['mail'] = 'update@gmail.com';
        $updateUserEntity = new UserEntity($updateUser);
        $errorCode = $this->userRepository->updateUser($updateUserEntity);

        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * 自身のメールアドレス以外に既に存在するメールアドレスでユーザーエンティティを更新する。
     */
    public function testUpdateExistsMailUser(): void
    {
        $firstUser = $this->user;
        $firstUserEntity = new UserEntity($firstUser);
        $this->userRepository->createUser($firstUserEntity);

        $secondUser = $this->user;
        $secondUser['id'] = $secondUser['id'] + 1;
        $secondUser['mail'] = 'second@gmail.com';
        $secondUserEntity = new UserEntity($secondUser);
        $this->userRepository->createUser($secondUserEntity);

        $firstUser['mail'] = 'second@gmail.com';
        $firstUserEntity = new UserEntity($firstUser);
        $errorCode = $this->userRepository->updateUser($firstUserEntity);

        $this->assertSame($errorCode, self::EXISTS_MAIL_CODE);

        $this->userRepository->deleteUser($firstUserEntity);
        $this->userRepository->deleteUser($secondUserEntity);
    }

    /**
     * ユーザーエンティティをDBから削除する。
     */
    public function testDeleteUser(): void
    {
        $userEntity = new UserEntity($this->user);
        $this->userRepository->createUser($userEntity);

        $errorCode = $this->userRepository->deleteUser($userEntity);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * IDが最大のユーザーを削除する。
     */
    public function testDeleteMaxIdUser(): void
    {
        $userEntity = new UserEntity($this->user);
        $this->userRepository->createUser($userEntity);

        $errorCode = $this->userRepository->deleteMaxIdUser();
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }
}
