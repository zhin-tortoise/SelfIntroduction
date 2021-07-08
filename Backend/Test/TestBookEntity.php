<?php

/**
 * 書籍エンティティの振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Domain/BookEntity.php');

class TestBookEntity extends TestCase
{
    private int $id = 100; // 書籍ID
    private int $userId = 1000; // ユーザーID
    private string $title = '題名'; // 題名
    private string $explainText = '説明'; // 説明
    private string $picture = '../picture.jpg'; // 写真
    private array $book; // 書籍エンティティ作成用の配列

    /**
     * 書籍エンティティ作成用の配列を用意する。
     */
    public function setUp(): void
    {
        $this->book = [
            'id' => $this->id,
            'userId' => $this->userId,
            'title' => $this->title,
            'explainText' => $this->explainText,
            'picture' => $this->picture
        ];
    }

    /**
     * 書籍エンティティを作成する。
     */
    public function testCreateBookEntity(): void
    {
        $bookEntity = new BookEntity($this->book);

        $this->assertSame($bookEntity->getId(), $this->id);
        $this->assertSame($bookEntity->getUserId(), $this->userId);
        $this->assertSame($bookEntity->getTitle(), $this->title);
        $this->assertSame($bookEntity->getExplainText(), $this->explainText);
        $this->assertSame($bookEntity->getPicture(), $this->picture);
    }

    /**
     * 空のデータで書籍エンティティを作成する。
     */
    public function testCreateEmptyBookEntity(): void
    {
        $bookEntity = new BookEntity([]);

        $this->assertSame($bookEntity->getId(), null);
        $this->assertSame($bookEntity->getUserId(), 0);
        $this->assertSame($bookEntity->getTitle(), '');
        $this->assertSame($bookEntity->getExplainText(), '');
        $this->assertSame($bookEntity->getPicture(), '');
    }

    /**
     * IDが空の書籍エンティティを作成する。
     */
    public function testCreateEmptyIdBook(): void
    {
        $book = $this->book;
        $book['id'] = '';
        $bookEntity = new BookEntity($book);

        $this->assertNull($bookEntity->getId());
    }
}
