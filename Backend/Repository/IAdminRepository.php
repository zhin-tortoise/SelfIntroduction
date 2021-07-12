<?php

/**
 * 管理者リポジトリのインターフェース。
 */

interface IAdminRepository
{
    public function createAdmin(AdminEntity $adminEntity): string;
    public function readAdminFromMail(string $mail);
    public function updateAdmin(AdminEntity $adminEntity): string;
    public function deleteAdmin(AdminEntity $adminEntity): string;
}
