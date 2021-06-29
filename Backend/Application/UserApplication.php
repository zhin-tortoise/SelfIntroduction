<?php

require_once(dirname(__FILE__) . '/../domain/UserEntity.php');
require_once(dirname(__FILE__) . '/../repository/UserRepository.php');
require_once(dirname(__FILE__) . '/../repository/MysqlRepository.php');

/**
 * ユーザーのアプリケーションクラス。
 * ユーザーのユースケースを記載するクラス。
 */

class UserApplication
{
    /**
     * ユーザーを作成する。
     * @param array $user ユーザーの配列。
     * @return string エラーコード。
     */
    public function createUser(array $user): string
    {
        $mysql = new Mysql();
        $userRepository = new UserRepository($mysql->getPdo());
        $userEntity = new UserEntity($user);
        $errorCode = $userRepository->createUser($userEntity);

        return $errorCode;
    }

    /**
     * IDからユーザーを取得する。
     * @param int $id 取得するユーザーのID。
     * @return UserEntity | false 引数で与えられたIDに紐づくユーザーエンティティ。
     *                            存在しないメールアドレスの場合は、falseが返る。
     */
    public function readUserFromID(int $id)
    {
        $mysql = new Mysql();
        $userRepository = new UserRepository($mysql->getPdo());

        return $userRepository->readUserFromID($id);
    }

    /**
     * メールアドレスからユーザーを取得する。
     * @param string $mail 取得するユーザーのメールアドレス。
     * @return UserEntity | false 引数で与えられたメールアドレスに紐づくユーザーエンティティ。
     *                            存在しないメールアドレスの場合は、falseが返る。
     */
    public function readUserFromMail(string $mail)
    {
        $mysql = new Mysql();
        $userRepository = new UserRepository($mysql->getPdo());

        return $userRepository->readUserFromMail($mail);
    }

    /**
     * 全てのユーザーを取得する。
     * @return array DBに登録されている全てのユーザー。
     */
    public function readAllUser(): array
    {
        $mysql = new Mysql();
        $userRepository = new UserRepository($mysql->getPdo());

        return $userRepository->readAllUser();
    }

    /**
     * ユーザーを更新する。
     * @param array $user ユーザーの配列。
     * @return string エラーコード。
     */
    public function updateUser(array $user): string
    {
        $mysql = new Mysql();
        $userEntity = new UserEntity($user);
        $userRepository = new UserRepository($mysql->getPdo());

        return $userRepository->updateUser($userEntity);
    }

    /**
     * ユーザーを削除する。
     * @param array $user ユーザーの配列。
     * @return string エラーコード。
     */
    public function deleteUser(array $user): string
    {
        $mysql = new Mysql();
        $userRepository = new UserRepository($mysql->getPdo());
        $userEntity = new UserEntity($user);
        $errorCode = $userRepository->deleteUser($userEntity);

        return $errorCode;
    }
}
