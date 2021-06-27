<?php

interface IUserRepository
{
    public function create(UserEntity $userEntity): string;
    public function delete(UserEntity $userEntity): string;
}
