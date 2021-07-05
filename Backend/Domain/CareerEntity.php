<?php

/**
 * 1つの経歴を表すエンティティ。
 */

class CareerEntity
{
    private $id; // 経歴ID。nullを許容するため、intの型宣言はなし。
    private int $userId; // ユーザーID。
    private $startDate; // 開始日。nullを許容するため、stringの型宣言はなし。
    private $finishDate; // 終了日。nullを許容するため、stringの型宣言はなし。
    private string $overview; // 概要。
    private string $explainText; // 説明。

    /**
     * 引数で与えられた配列の各要素をプロパティに設定する。
     * @param array $career CareerEntityに設定する要素が含まれた配列。
     */
    public function __construct(array $career)
    {
        $this->id = array_key_exists('id', $career) && !empty($career['id']) ? $career['id'] : null;
        $this->userId = array_key_exists('userId', $career) ? $career['userId'] : 0;
        $this->startDate = array_key_exists('startDate', $career) && !empty($career['startDate']) ? $career['startDate'] : null;
        $this->finishDate = array_key_exists('finishDate', $career) && !empty($career['finishDate']) ? $career['finishDate'] : null;
        $this->overview = array_key_exists('overview', $career) ? $career['overview'] : '';
        $this->explainText = array_key_exists('explainText', $career) ? $career['explainText'] : '';
    }

    /**
     * 経歴IDのゲッター。
     * @return int|null 経歴ID。
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
     * 開始日のゲッター。
     * @return string 開始日。
     */
    public function getStartDate() // nullが返る場合とstringが返る場合があるため、戻り値の型宣言はない。
    {
        return $this->startDate;
    }

    /**
     * 終了日のゲッター。
     * @return string 終了日。
     */
    public function getFinishDate() // nullが返る場合とstringが返る場合があるため、戻り値の型宣言はない。
    {
        return $this->finishDate;
    }

    /**
     * 概要のゲッター。
     * @return string 概要。
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * 説明のゲッター。
     * @return string 説明。
     */
    public function getExplainText(): string
    {
        return $this->explainText;
    }
}
