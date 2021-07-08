<?php

/**
 * 書籍の振る舞いについてテストを行うクラス。
 */

use PHPUnit\Framework\TestCase;

require_once(dirname(__FILE__) . '/../Repository/MysqlRepository.php');
require_once(dirname(__FILE__) . '/../Repository/BookRepository.php');
require_once(dirname(__FILE__) . '/../Domain/BookEntity.php');
require_once(dirname(__FILE__) . '/../Repository/UserRepository.php');
require_once(dirname(__FILE__) . '/../Domain/UserEntity.php');

class TestBookRepository extends TestCase
{
    const SUCCESS_CODE = '00000'; // リポジトリから返される成功時のステータスコード。

    private int $id = 100; // 書籍ID
    private int $userId = 1000; // ユーザーID
    private string $title = '題名'; // 題名
    private string $explainText = '説明'; // 説明
    private string $picture = '../picture.jpg'; // 写真
    private array $book; // 書籍作成用の配列

    private BookRepository $bookRepository; // 書籍のリポジトリ
    private UserRepository $userRepository; // ユーザーのリポジトリ

    /**
     * 書籍エンティティ作成用の配列を用意する。
     * 書籍のリポジトリを用意する。
     * ユーザーを作成する。
     */
    public function setUp(): void
    {
        // 書籍エンティティ作成用の配列を用意する。
        $this->book = [
            'id' => $this->id,
            'userId' => $this->userId,
            'title' => $this->title,
            'explainText' => $this->explainText,
            'picture' => $this->picture
        ];

        // 書籍のリポジトリを用意する。
        $mysql = new Mysql();
        $this->bookRepository = new BookRepository($mysql->getPdo());

        // ユーザーを作成する。
        $this->userRepository = new UserRepository($mysql->getPdo());
        $userEntity = new UserEntity(['id' => $this->userId]);
        $this->userRepository->createUser($userEntity);
    }

    /**
     * ユーザーを削除する。
     */
    public function tearDown(): void
    {
        $userEntity = new UserEntity(['id' => $this->userId]);
        $this->userRepository->deleteUser($userEntity);
    }

    /**
     * 書籍エンティティを作成し、DBに登録する。
     */
    public function testCreateBook(): void
    {
        $bookEntity = new BookEntity($this->book);
        $errorCode = $this->bookRepository->createBook($bookEntity);

        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * IDが空の書籍エンティティを作成し、DBに登録する。
     */
    public function testCreateEmptyIdBook()
    {
        $book = $this->book;
        $book['id'] = '';
        $bookEntity = new BookEntity($book);
        $errorCode = $this->bookRepository->createBook($bookEntity);

        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }

    /**
     * IDから書籍エンティティを取得する。
     */
    public function testReadBookFromId(): void
    {
        $bookEntity = new BookEntity($this->book);
        $this->bookRepository->createBook($bookEntity);
        $dbBookEntity = $this->bookRepository->readBookFromId($this->book['id']);

        $this->assertSame($dbBookEntity->getId(), (string)$this->book['id']);
    }

    /**
     * ユーザーIDから書籍エンティティを取得する。
     */
    public function testReadBookFromUserId(): void
    {
        $bookEntity = new BookEntity($this->book);
        $this->bookRepository->createBook($bookEntity);
        $books = $this->bookRepository->readBookFromUserId($this->book['userId']);

        $this->assertFalse(empty($books));
    }

    /**
     * 全ての書籍エンティティを取得する。
     */
    public function testReadAllBook(): void
    {
        $bookEntity = new BookEntity($this->book);
        $this->bookRepository->createBook($bookEntity);
        $books = $this->bookRepository->readAllBook();

        $this->assertFalse(empty($books));
    }

    /**
     * 書籍エンティティを更新する。
     */
    public function testUpdateBook(): void
    {
        $bookEntity = new BookEntity($this->book);
        $this->bookRepository->createBook($bookEntity);

        $book = $this->book;
        $book['title'] = '更新用の題名';
        $book['explainText'] = '更新用の説明';
        $book['picture'] = '../update/jpg';

        $updateBook = new BookEntity($book);
        $this->bookRepository->updateBook($updateBook);
        $dbUpdateBookEntity = $this->bookRepository->readBookFromId($book['id']);

        $this->assertSame($dbUpdateBookEntity->getId(), (string)$book['id']);
        $this->assertSame($dbUpdateBookEntity->getUserId(), $book['userId']);
        $this->assertSame($dbUpdateBookEntity->getTitle(), $book['title']);
        $this->assertSame($dbUpdateBookEntity->getExplainText(), $book['explainText']);
        $this->assertSame($dbUpdateBookEntity->getPicture(), $book['picture']);
    }

    /**
     * 書籍エンティティをDBから削除する。
     */
    public function testDeleteBook(): void
    {
        $bookEntity = new BookEntity($this->book);
        $this->bookRepository->createBook($bookEntity);

        $errorCode = $this->bookRepository->deleteBook($bookEntity);
        $this->assertSame($errorCode, self::SUCCESS_CODE);
    }
}
