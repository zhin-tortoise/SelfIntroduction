<?php

require_once(dirname(__FILE__) . '/../Domain/AdminEntity.php');
require_once(dirname(__FILE__) . '/../Repository/AdminRepository.php');
require_once(dirname(__FILE__) . '/../Repository/MysqlRepository.php');

/**
 * 管理者のアプリケーションクラス。
 * 管理者のユースケースを記載するクラス。
 */

class AdminApplication
{
    private $adminRepository; // 管理者リポジトリ

    public function __construct()
    {
        $mysql = new Mysql();
        $this->adminRepository = new AdminRepository($mysql->getPdo());
    }

    /**
     * 管理者を作成する。
     * @param array $admin 管理者の配列。
     * @return string エラーコード。
     */
    public function createAdmin(array $admin): string
    {
        $adminEntity = new AdminEntity($admin);
        $errorCode = $this->adminRepository->createAdmin($adminEntity);

        return $errorCode;
    }

    /**
     * メールアドレスから管理者を取得する。
     * @param string $mail メールアドレス。
     * @return AdminEntity | false 引数で与えられたメールアドレスに紐づく管理者エンティティ。
     *                             存在しないメールアドレスの場合は、falseが返る。
     */
    public function readAdminFromMail(string $mail)
    {
        return $this->adminRepository->readAdminFromMail($mail);
    }

    /**
     * 管理者を更新する。
     * @param array $admin 管理者の配列。
     * @return string エラーコード。
     */
    public function updateAdmin(array $admin): string
    {
        $adminEntity = new AdminEntity($admin);
        $errorCode = $this->adminRepository->updateAdmin($adminEntity);

        return $errorCode;
    }

    /**
     * 管理者を削除する。
     * @param array $admin 管理者の配列。
     * @return string エラーコード。
     */
    public function deleteAdmin(array $admin): string
    {
        $adminEntity = new AdminEntity($admin);
        $errorCode = $this->adminRepository->deleteAdmin($adminEntity);

        return $errorCode;
    }
}
