<?php

require_once(dirname(__FILE__) . '/../Domain/UserEntity.php');
require_once(dirname(__FILE__) . '/../Repository/UserRepository.php');
require_once(dirname(__FILE__) . '/../Repository/MysqlRepository.php');

/**
 * ユーザーのアプリケーションクラス。
 * ユーザーのユースケースを記載するクラス。
 */

class UserApplication
{
    private $userRepository; // ユーザーリポジトリ

    public function __construct()
    {
        $mysql = new Mysql();
        $this->userRepository = new UserRepository($mysql->getPdo());
    }

    /**
     * ユーザーを作成する。
     * @param array $user ユーザーの配列。
     * @return string エラーコード。
     */
    public function createUser(array $user): string
    {
        $userEntity = new UserEntity($user);
        $errorCode = $this->userRepository->createUser($userEntity);

        return $errorCode;
    }

    /**
     * IDからユーザーを取得する。
     * @param int $id 取得するユーザーのID。
     * @return UserEntity | false 引数で与えられたIDに紐づくユーザーエンティティ。
     *                            存在しないIDの場合は、falseが返る。
     */
    public function readUserFromId(int $id)
    {
        return $this->userRepository->readUserFromId($id);
    }

    /**
     * メールアドレスからユーザーを取得する。
     * @param string $mail 取得するユーザーのメールアドレス。
     * @return UserEntity | false 引数で与えられたメールアドレスに紐づくユーザーエンティティ。
     *                            存在しないメールアドレスの場合は、falseが返る。
     */
    public function readUserFromMail(string $mail)
    {
        return $this->userRepository->readUserFromMail($mail);
    }

    /**
     * 全てのユーザーを取得する。
     * @return array DBに登録されている全てのユーザー。
     */
    public function readAllUser(): array
    {
        return $this->userRepository->readAllUser();
    }

    /**
     * ユーザーを更新する。
     * @param array $user ユーザーの配列。
     * @return string エラーコード。
     */
    public function updateUser(array $user): string
    {
        $userEntity = new UserEntity($user);

        return $this->userRepository->updateUser($userEntity);
    }

    /**
     * ユーザーを削除する。
     * @param array $user ユーザーの配列。
     * @return string エラーコード。
     */
    public function deleteUser(array $user): string
    {
        $userEntity = new UserEntity($user);
        $errorCode = $this->userRepository->deleteUser($userEntity);

        return $errorCode;
    }

    /**
     * IDが最大のユーザーを削除する。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function deleteMaxIdUser(): string
    {
        return $this->userRepository->deleteMaxIdUser();
    }
}
