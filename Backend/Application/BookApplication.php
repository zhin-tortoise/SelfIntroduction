<?php

require_once(dirname(__FILE__) . '/../Domain/BookEntity.php');
require_once(dirname(__FILE__) . '/../Repository/BookRepository.php');
require_once(dirname(__FILE__) . '/../Repository/MysqlRepository.php');

/**
 * 書籍のアプリケーションクラス。
 * 書籍のユースケースを記載するクラス。
 */

class BookApplication
{
    private $bookRepository; // 書籍リポジトリ

    public function __construct()
    {
        $mysql = new Mysql();
        $this->bookRepository = new BookRepository($mysql->getPdo());
    }

    /**
     * 書籍を作成する。
     * @param array $book 書籍の配列。
     * @return string エラーコード。
     */
    public function createBook(array $book): string
    {
        $bookEntity = new BookEntity($book);
        $errorCode = $this->bookRepository->createBook($bookEntity);

        return $errorCode;
    }

    /**
     * 書籍を削除する。
     * @param array $book 書籍の配列。
     * @return string エラーコード。
     */
    public function deleteBook(array $book): string
    {
        $bookEntity = new BookEntity($book);
        $errorCode = $this->bookRepository->deleteBook($bookEntity);

        return $errorCode;
    }
}
