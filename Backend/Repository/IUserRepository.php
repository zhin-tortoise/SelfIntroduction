<?php

/**
 * ユーザーリポジトリのインターフェース。
 */

interface IUserRepository
{
    public function createUser(UserEntity $userEntity): string;
    public function readUserFromId(int $id);
    public function readUserFromMail(string $mail);
    public function readAllUser(): array;
    public function updateUser(UserEntity $userEntity): string;
    public function deleteUser(UserEntity $userEntity): string;
    public function deleteMaxIdUser(): string;
}
