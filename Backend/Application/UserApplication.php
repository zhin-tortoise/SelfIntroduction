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
