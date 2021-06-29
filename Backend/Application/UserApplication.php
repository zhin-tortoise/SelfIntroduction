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
    public function create(array $user): string
    {
        $mysql = new Mysql();
        $userRepository = new UserRepository($mysql->getPdo());
        $userEntity = new UserEntity($user);
        $errorCode = $userRepository->create($userEntity);

        return $errorCode;
    }

    /**
     * IDからユーザーを取得する。
     * @param int $id 取得するユーザーのID。
     * @return UserEntity | false 引数で与えられたIDに紐づくユーザーエンティティ。
     *                            存在しないメールアドレスの場合は、falseが返る。
     */
    public function readFromID(int $id)
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
    public function readFromMail(string $mail)
    {
        $mysql = new Mysql();
        $userRepository = new UserRepository($mysql->getPdo());

        return $userRepository->readUserFromMail($mail);
    }

    /**
     * 全てのユーザーを取得する。
     * @return array DBに登録されている全てのユーザー。
     */
    public function readAll(): array
    {
        $mysql = new Mysql();
        $userRepository = new UserRepository($mysql->getPdo());

        return $userRepository->readAllUser();
    }

    /**
     * ユーザーを削除する。
     * @param array $user ユーザーの配列。
     * @return string エラーコード。
     */
    public function delete(array $user): string
    {
        $mysql = new Mysql();
        $userRepository = new UserRepository($mysql->getPdo());
        $userEntity = new UserEntity($user);
        $errorCode = $userRepository->delete($userEntity);

        return $errorCode;
    }
}
