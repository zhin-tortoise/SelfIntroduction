<?php

/**
 * 1人のユーザーを表すエンティティ。
 */

class UserEntity
{
    private $id; // ユーザーID。nullを許容するため、intの型宣言はなし。
    private string $name; // ユーザー名
    private string $mail; // メールアドレス
    private string $password; // パスワード
    private string $picture; // 写真
    private $birthday; // 誕生日。nullを許容するため、stringの型宣言はなし。nullを許容する理由はnullでのinsertに対応するため。
    private string $gender; // 性別
    private string $background; // 経歴
    private string $qualification; // 資格
    private string $profile; // プロフィール

    /**
     * 引数で与えられた配列の各要素をプロパティに設定する。
     * @param array $user UserEntityに設定する要素が含まれた配列。
     */
    public function __construct(array $user)
    {
        $this->id = array_key_exists('id', $user) && !empty($user['id']) ? $user['id'] : null;
        $this->name = array_key_exists('name', $user) ? $user['name'] : '';
        $this->mail = array_key_exists('mail', $user) ? $user['mail'] : '';
        if (array_key_exists('password', $user)) {
            $this->password = $this->is_bcrypt_hash($user['password']) ? $user['password'] : password_hash($user['password'], PASSWORD_BCRYPT);
        } else {
            $this->password = '';
        }
        $this->picture = array_key_exists('picture', $user) ? $user['picture'] : '';
        $this->birthday = array_key_exists('birthday', $user) && !empty($user['birthday']) ? $user['birthday'] : null;
        $this->gender = array_key_exists('gender', $user) ? $user['gender'] : '';
        $this->background = array_key_exists('background', $user) ? $user['background'] : '';
        $this->qualification = array_key_exists('qualification', $user) ? $user['qualification'] : '';
        $this->profile = array_key_exists('profile', $user) ? $user['profile'] : '';
    }

    /**
     * ユーザーIDのゲッター。
     * @return int ユーザーID。
     */
    public function getID() // nullが返る場合とintが返る場合があるため、戻り値の型宣言はない。
    {
        return $this->id;
    }

    /**
     * ユーザー名のゲッター。
     * @return string ユーザー名。
     */
    public function getName(): string
    {
        return $this->name;
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
     * 写真のゲッター。
     * @return string 写真。
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * 誕生日のゲッター。
     * @return string 誕生日。
     */
    public function getBirthday() // nullが返る場合とstringが返る場合があるため、戻り値の型宣言はない。
    {
        return $this->birthday;
    }

    /**
     * 性別のゲッター。
     * @return string 性別。
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * 経歴のゲッター。
     * @return string 経歴。
     */
    public function getBackground(): string
    {
        return $this->background;
    }

    /**
     * 資格のゲッター。
     * @return string 資格。
     */
    public function getQualification(): string
    {
        return $this->qualification;
    }

    /**
     * プロフィールのゲッター。
     * @return string プロフィール。
     */
    public function getProfile(): string
    {
        return $this->profile;
    }

    /**
     * パスワードがbcryptハッシュならtrue、それ以外ならfalseを返す。
     */
    private function is_bcrypt_hash($password): bool
    {
        return strlen($password) === 60 && mb_substr($password, 0, 2) === '$2';
    }
}
