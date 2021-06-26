<?php

/**
 * ユーザーのリポジトリ。
 * ユーザーテーブルへのアクセスを担う。
 */

require_once(dirname(__FILE__) . '/IUserRepository.php');

class UserRepository implements IUserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(UserEntity $userEntity)
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
}
