<?php

/**
 * 1つの管理者を表すエンティティ。
 */

class AdminEntity
{
    private $id; // 管理者ID。
    private $mail; // メールアドレス。
    private $password; // パスワード。

    /**
     * 引数で与えられた配列の各要素をプロパティに設定する。
     * @param array $admin AdminEntityに設定する要素が含まれた配列。
     */
    public function __construct(array $admin)
    {
        $this->id = array_key_exists('id', $admin) && !empty($admin['id']) ? $admin['id'] : null;
        $this->mail = array_key_exists('mail', $admin) ? $admin['mail'] : '';
        if (array_key_exists('password', $admin)) {
            $this->password = $this->is_bcrypt_hash($admin['password']) ? $admin['password'] : password_hash($admin['password'], PASSWORD_BCRYPT);
        } else {
            $this->password = '';
        }
    }

    /**
     * 管理者IDのゲッター。
     * @return int|null 管理者ID。
     */
    public function getId() // nullが返る場合とintが返る場合があるため、戻り値の型宣言はない。
    {
        return $this->id;
    }

    /**
     * メールアドレスのゲッター。
     * @return string メールアドレス。
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * パスワードのゲッター。
     * @return string パスワード。
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * パスワードがbcryptハッシュならtrue、それ以外ならfalseを返す。
     */
    private function is_bcrypt_hash($password): bool
    {
        return strlen($password) === 60 && mb_substr($password, 0, 2) === '$2';
    }
}
