<?php

/**
 * 書籍リポジトリのインターフェース。
 */

interface IBookRepository
{
    public function createBook(BookEntity $bookEntity): string;
}
