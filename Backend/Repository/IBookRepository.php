<?php

/**
 * 書籍リポジトリのインターフェース。
 */

interface IBookRepository
{
    public function createBook(BookEntity $bookEntity): string;
    public function readBookFromId(int $id);
    public function readBookFromUserId(int $userId): array;
    public function readAllBook(): array;
    public function deleteBook(BookEntity $bookEntity): string;
}
