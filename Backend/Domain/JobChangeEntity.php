<?php

/**
 * 1つの転職事由を表すエンティティ。
 */

class JobChangeEntity
{
    private $id; // 転職ID。nullを許容するため、intの型宣言はなし。
    private int $userId; // ユーザーID。
    private string $reason; // 転職理由。
    private string $motivation; // 志望動機。
    private string $experience; // 活かせる経験。

    /**
     * 引数で与えられた配列の各要素をプロパティに設定する。
     * @param array $jobChange JobChangeEntityに設定する要素が含まれた配列。
     */
    public function __construct(array $jobChange)
    {
        $this->id = array_key_exists('id', $jobChange) && !empty($jobChange['id']) ? $jobChange['id'] : null;
        $this->userId = array_key_exists('userId', $jobChange) ? $jobChange['userId'] : 0;
        $this->reason = array_key_exists('reason', $jobChange) ? $jobChange['reason'] : '';
        $this->motivation = array_key_exists('motivation', $jobChange) ? $jobChange['motivation'] : '';
        $this->experience = array_key_exists('experience', $jobChange) ? $jobChange['experience'] : '';
    }

    /**
     * 転職IDのゲッター。
     * @return int|null 転職ID。
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
     * 転職理由のゲッター。
     * @return string 転職理由。
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * 志望動機のゲッター。
     * @return string 志望動機。
     */
    public function getMotivation(): string
    {
        return $this->motivation;
    }

    /**
     * 活かせる経験のゲッター。
     * @return string 活かせる経験。
     */
    public function getExperience(): string
    {
        return $this->experience;
    }
}
