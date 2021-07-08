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
     * ユーザーIDから書籍を取得する。
     * @param int $userId 取得するユーザーID。
     * @return BookEntity | false 引数で与えられたユーザーIDに紐づく書籍エンティティ。
     *                            存在しないIDの場合は、falseが返る。
     */
    public function readBookFromUserId(int $userId): array
    {
        return $this->bookRepository->readBookFromUserId($userId);
    }

    /**
     * 全ての書籍を取得する。
     * @return array DBに登録されている全ての書籍。
     */
    public function readAllBook(): array
    {
        return $this->bookRepository->readAllBook();
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
