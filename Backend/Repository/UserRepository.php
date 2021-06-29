<?php

/**
 * ユーザーのリポジトリ。
 * ユーザーテーブルへのアクセスを担う。
 */

require_once(dirname(__FILE__) . '/IUserRepository.php');
require_once(dirname(__FILE__) . '/../domain/UserEntity.php');

class UserRepository implements IUserRepository
{
    const EXISTS_MAIL_CODE = '99998';
    private PDO $pdo; // DBアクセスを行うPDOクラス。

    /**
     * コンストラクタでPDOを設定する。
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * ユーザーエンティティを引数から取得し、そのユーザーをDBに登録する。
     * @param UserEntity $userEntity 登録するユーザー。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function createUser(UserEntity $userEntity): string
    {
        if ($this->readUserFromMail($userEntity->getMail())) {
            return self::EXISTS_MAIL_CODE;
        }

        $sql = 'insert into user values ( ';
        $sql .= ':id, :name, :mail, :password, :picture, :birthday, :gender, :background, :qualification, :profile';
        $sql .= ');';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $userEntity->getId());
        $stmt->bindValue(':name', $userEntity->getName());
        $stmt->bindValue(':mail', $userEntity->getMail());
        $stmt->bindValue(':password', $userEntity->getPassword());
        $stmt->bindValue(':picture', $userEntity->getPicture());
        $stmt->bindValue(':birthday', $userEntity->getBirthday());
        $stmt->bindValue(':gender', $userEntity->getGender());
        $stmt->bindValue(':background', $userEntity->getBackground());
        $stmt->bindValue(':qualification', $userEntity->getQualification());
        $stmt->bindValue(':profile', $userEntity->getProfile());

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return $e->getCode();
        }

        return $stmt->errorCode();
    }

    /**
     * IDを引数から取得し、そのIDからユーザーを読み取り、ユーザーエンティティを返す。
     * @param int $id ユーザーID。
     * @return UserEntity | false 引数で与えられたIDに紐づくユーザーエンティティ。
     *                            存在しないメールアドレスの場合は、falseが返る。
     */
    public function readUserFromID(int $id)
    {
        $sql = 'select * from user where id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->rowCount() ? new UserEntity($stmt->fetch()) : false;
    }

    /**
     * メールアドレスを引数から取得し、そのメールアドレスからユーザーを読み取り、ユーザーエンティティを返す。
     * @param string $mail ユーザーのメールアドレス。
     * @return UserEntity | false 引数で与えられたメールアドレスに紐づくユーザーエンティティ。
     *                            存在しないメールアドレスの場合は、falseが返る。
     */
    public function readUserFromMail(string $mail)
    {
        $sql = 'select * from user where mail = :mail;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':mail', $mail);
        $stmt->execute();

        return $stmt->rowCount() ? new UserEntity($stmt->fetch()) : false;
    }

    /**
     * 全てのユーザーを取得する。
     * @return array DBに登録されている全てのユーザーエンティティが含まれた配列。
     */
    public function readAllUser(): array
    {
        $sql = 'select * from user;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $userEntities = [];
        foreach ($stmt->fetchAll() as $user) {
            $userEntities[] = new UserEntity($user);
        }

        return $userEntities;
    }

    /**
     * ユーザーエンティティを引数から取得し、そのユーザーをDBに更新する。
     * @param UserEntity $userEntity 更新するユーザー。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function updateUser(UserEntity $userEntity): string
    {
        if (
            $this->readUserFromMail($userEntity->getMail())
            && $userEntity->getID() !== $this->readUserFromMail($userEntity->getMail())->getID()
        ) {
            return self::EXISTS_MAIL_CODE;
        }

        $sql = 'update user set name = :name, mail = :mail, password = :password, ';
        $sql .= 'picture = :picture, birthday = :birthday, gender = :gender, ';
        $sql .= 'background = :background, qualification = :qualification, profile = :profile ';
        $sql .= 'where id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $userEntity->getID());
        $stmt->bindValue(':name', $userEntity->getName());
        $stmt->bindValue(':mail', $userEntity->getMail());
        $stmt->bindValue(':password', $userEntity->getPassword());
        $stmt->bindValue(':picture', $userEntity->getPicture());
        $stmt->bindValue(':birthday', $userEntity->getBirthday());
        $stmt->bindValue(':gender', $userEntity->getGender());
        $stmt->bindValue(':background', $userEntity->getBackground());
        $stmt->bindValue(':qualification', $userEntity->getQualification());
        $stmt->bindValue(':profile', $userEntity->getProfile());

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return $e->getCode();
        }

        return $stmt->errorCode();
    }

    /**
     * ユーザーエンティティを引数から取得し、そのユーザーをDBから削除する。
     * @param UserEntity $userEntity 削除するユーザー。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function deleteUser(UserEntity $userEntity): string
    {
        $sql = 'delete from user where id = :id;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $userEntity->getID());

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return $e->getCode();
        }

        return $stmt->errorCode();
    }

    /**
     * IDが最大のユーザーを削除する。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function deleteMaxIDUser()
    {
        $sql = 'delete from user order by id desc limit 1;';
        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return $e->getCode();
        }

        return $stmt->errorCode();
    }
}
