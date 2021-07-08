<?php

/**
 * 書籍アプリケーションの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Application/BookApplication.php');
require_once(dirname(__FILE__) . '/../Application/UserApplication.php');

class TestBookApplication extends TestCase
{
    const SUCCESS_CODE = '00000'; // リポジトリから返される成功時のステータスコード。

    private int $id = 100; // 書籍ID
    private int $userId = 1000; // ユーザーID
    private string $title = '題名'; // 題名
    private string $explainText = '説明'; // 説明
    private string $picture = '../picture.jpg'; // 写真
    private array $book; // 書籍作成用の配列

    private BookApplication $bookApplication; // 書籍アプリケーション
    private UserApplication $userApplication; // ユーザーアプリケーション

    /**
     * 書籍作成用の配列を用意する。
     * 書籍アプリケーションを作成する。
     * 書籍作成の外部キー制約を回避するため、ユーザーを作成する。
     */
    public function setUp(): void
    {
        // 書籍作成用の配列を用意する。
        $this->book = [
            'id' => $this->id,
            'userId' => $this->userId,
            'title' => $this->title,
            'explainText' => $this->explainText,
            'picture' => $this->picture
        ];

        // 書籍アプリケーションを作成する。
        $this->bookApplication = new BookApplication();

        // 書籍作成の外部キー制約を回避するため、ユーザーを作成する。
        $this->userApplication = new UserApplication();
        $this->userApplication->createUser(['id' => $this->userId]);
    }

    /**
     * ユーザーを削除する。
     */
    public function tearDown(): void
    {
        $this->userApplication->deleteUser(['id' => $this->userId]);
    }

    /**
     * 書籍を作成する。
     */
    public function testCreateBook(): void
    {
        $errorCode = $this->bookApplication->createBook($this->book);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * 書籍を削除する。
     */
    public function testDeleteBook(): void
    {
        $errorCode = $this->bookApplication->deleteBook($this->book);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }
}
