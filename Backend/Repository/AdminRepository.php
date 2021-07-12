<?php

/**
 * 管理者のリポジトリ。
 * 管理者テーブルへのアクセスを担う。
 */

require_once(dirname(__FILE__) . '/IAdminRepository.php');
require_once(dirname(__FILE__) . '/../Domain/AdminEntity.php');

class AdminRepository implements IAdminRepository
{
    private PDO $pdo; // DBアクセスを行うPDOクラス。

    /**
     * コンストラクタでPDOを設定する。
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 管理者エンティティを引数から取得し、その管理者をDBに登録する。
     * @param AdminEntity $adminEntity 登録する管理者。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function createAdmin(AdminEntity $adminEntity): string
    {
        $sql = 'insert into admin values ( ';
        $sql .= ':id, :mail, :password ';
        $sql .= ');';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $adminEntity->getId());
        $stmt->bindValue(':mail', $adminEntity->getMail());
        $stmt->bindValue(':password', $adminEntity->getPassword());

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return $e->getCode();
        }

        return $stmt->errorCode();
    }

    /**
     * メールアドレスを引数から取得し、そのメールアドレスから管理者を読み取り、管理者エンティティを返す。
     * @param string $mail メールアドレス。
     * @return AdminEntity|false 引数で与えられたメールアドレスに紐づく管理者エンティティ。
     */
    public function readAdminFromMail(string $mail)
    {
        $sql = 'select * from admin where mail = :mail';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':mail', $mail);
        $stmt->execute();

        return $stmt->rowCount() ? new AdminEntity($stmt->fetch()) : false;
    }

    /**
     * 管理者エンティティを引数から取得し、その管理者をDBに更新する。
     * @param AdminEntity $adminEntity 更新する管理者。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function updateAdmin(AdminEntity $adminEntity): string
    {
        $sql = 'update admin set id = :id, mail = :mail, password = :password ';
        $sql .= 'where id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $adminEntity->getId());
        $stmt->bindValue(':mail', $adminEntity->getMail());
        $stmt->bindValue(':password', $adminEntity->getPassword());

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return $e->getCode();
        }

        return $stmt->errorCode();
    }

    /**
     * 管理者エンティティを引数から取得し、その管理者をDBから削除する。
     * @param AdminEntity $adminEntity 削除する管理者。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function deleteAdmin(AdminEntity $adminEntity): string
    {
        $sql = 'delete from admin where id = :id;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $adminEntity->getId());
        $stmt->execute();

        return $stmt->errorCode();
    }
}
