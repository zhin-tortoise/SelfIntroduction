<?php

/**
 * ユーザーリポジトリのインターフェース。
 */

interface IUserRepository
{
    public function createUser(UserEntity $userEntity): string;
    public function deleteUser(UserEntity $userEntity): string;
}
