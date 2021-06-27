<?php

/**
 * ユーザーのリポジトリ。
 * ユーザーテーブルへのアクセスを担う。
 */

require_once(dirname(__FILE__) . '/IUserRepository.php');

class UserRepository implements IUserRepository
{
    private PDO $pdo;

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
    public function create(UserEntity $userEntity): string
    {
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
     * ユーザーエンティティを引数から取得し、そのユーザーをDBから削除する。
     */
    public function delete(UserEntity $userEntity): string
    {
        $sql = 'delete from user where id = :id;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $userEntity->getID());
        $stmt->execute();

        return $stmt->errorCode();
    }
}
