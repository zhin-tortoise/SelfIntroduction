<?php

/**
 * 1つの書籍を表すエンティティ。
 */

class BookEntity
{
    private $id; // 書籍ID。
    private $userId; // ユーザーID。
    private $title; // 題名。
    private $explainText; // 説明。
    private $picture; // 写真。

    /**
     * 引数で与えられた配列の各要素をプロパティに設定する。
     * @param array $book BookEntityに設定する要素が含まれた配列。
     */
    public function __construct(array $book)
    {
        $this->id = array_key_exists('id', $book) && !empty($book['id']) ? $book['id'] : null;
        $this->userId = array_key_exists('userId', $book) ? $book['userId'] : 0;
        $this->title = array_key_exists('title', $book) ? $book['title'] : '';
        $this->explainText = array_key_exists('explainText', $book) ? $book['explainText'] : '';
        $this->picture = array_key_exists('picture', $book) ? $book['picture'] : '';
    }

    /**
     * 書籍IDのゲッター。
     * @return int|null 書籍ID。
     */
    public function getId() // nullが返る場合とintが返る場合があるため、戻り値の型宣言はない。
    {
        return $this->id;
    }

    /**
     * ユーザーIDのゲッター。
     * @return int ユーザーID。
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * 題名のゲッター。
     * @return string 題名。
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * 説明のゲッター。
     * @return string 説明。
     */
    public function getExplainText(): string
    {
        return $this->explainText;
    }

    /**
     * 写真のゲッター。
     * @return string 写真。
     */
    public function getPicture(): string
    {
        return $this->picture;
    }
}
