<?php

require_once(dirname(__FILE__) . '/../domain/UserEntity.php');
require_once(dirname(__FILE__) . '/../repository/UserRepository.php');
require_once(dirname(__FILE__) . '/../repository/MysqlRepository.php');

/**
 * ユーザーのアプリケーションの。
 * ユーザーの操作を行うクラス。
 */

class UserApplication
{
    /**
     * ユーザーを作成する。
     */
    public function create(array $user)
    {
        $mysql = new Mysql();
        $userRepository = new UserRepository($mysql->getPdo());
        $userEntity = new UserEntity($user);
        $error_code = $userRepository->create($userEntity);

        return $error_code;
    }
}
