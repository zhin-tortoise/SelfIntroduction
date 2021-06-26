<?php

/**
 * 1人のユーザーを表すエンティティ。
 */

class UserEntity
{
    private int $id; // ユーザーID
    private string $name; // ユーザー名
    private string $mail; // メールアドレス
    private string $password; // パスワード
    private string $picture; // 写真
    private string $birthday; // 誕生日
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
        $this->id = $user['id'];
        $this->name = $user['name'];
        $this->mail = $user['mail'];
        $this->password = $user['password'];
        $this->picture = $user['picture'];
        $this->birthday = $user['birthday'];
        $this->gender = $user['gender'];
        $this->background = $user['background'];
        $this->qualification = $user['qualification'];
        $this->profile = $user['profile'];
    }

    /**
     * ユーザーIDのゲッター。
     * @return int ユーザーID。
     */
    public function getID(): int
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
    public function getBirthday(): string
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
}
