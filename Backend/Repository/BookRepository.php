<?php

/**
 * 書籍のリポジトリ。
 * 書籍テーブルへのアクセスを担う。
 */

require_once(dirname(__FILE__) . '/IBookRepository.php');
require_once(dirname(__FILE__) . '/../Domain/BookEntity.php');

class BookRepository implements IBookRepository
{
    private PDO $pdo; // DBアクセスを行うPDOクラス。

    /**
     * コンストラクタでPDOを設定する。
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 書籍エンティティを引数から取得し、その書籍をDBに登録する。
     * @param BookEntity $bookEntity 登録する書籍。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function createBook(BookEntity $bookEntity): string
    {
        $sql = 'insert into book values ( ';
        $sql .= ':id, :userId, :title, :explainText, :picture ';
        $sql .= ');';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $bookEntity->getId());
        $stmt->bindValue(':userId', $bookEntity->getUserId());
        $stmt->bindValue(':title', $bookEntity->getTitle());
        $stmt->bindValue(':explainText', $bookEntity->getExplainText());
        $stmt->bindValue(':picture', $bookEntity->getPicture());

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return $e->getCode();
        }

        return $stmt->errorCode();
    }

    /**
     * 書籍IDを引数から取得し、そのIDから書籍を読み取り、書籍エンティティを返す。
     * @param int $id 書籍ID。
     * @return BookEntity | false 引数で与えられた書籍IDに紐づく書籍エンティティ。
     *                            存在しないIDの場合は、falseが返る。
     */
    public function readBookFromId(int $id)
    {
        $sql = 'select * from book where id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->rowCount() ? new BookEntity($stmt->fetch()) : false;
    }

    /**
     * ユーザーIDを引数から取得し、そのIDから書籍を読み取り、書籍エンティティを返す。
     * @param int $userId ユーザーID。
     * @return array 引数で与えられたユーザーIDに紐づく書籍エンティティの配列。
     */
    public function readBookFromUserId(int $userId): array
    {
        $sql = 'select * from book where userId = :userId order by id desc';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();

        $books = [];
        foreach ($stmt->fetchAll() as $book) {
            $books[] = new BookEntity($book);
        }
        return $books;
    }

    /**
     * 全ての書籍を取得する。
     * @return array DBに登録されている全ての書籍エンティティが含まれた配列。
     */
    public function readAllBook(): array
    {
        $sql = 'select * from book;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $books = [];
        foreach ($stmt->fetchAll() as $book) {
            $books[] = new BookEntity($book);
        }
        return $books;
    }

    /**
     * 書籍エンティティを引数から取得し、その書籍をDBに更新する。
     * @param BookEntity $bookEntity 更新する書籍。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function updateBook(BookEntity $bookEntity): string
    {
        $sql = 'update book set userId = :userId, title = :title, ';
        $sql .= 'explainText = :explainText, picture = :picture ';
        $sql .= 'where id = :id;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $bookEntity->getId());
        $stmt->bindValue(':userId', $bookEntity->getUserId());
        $stmt->bindValue(':title', $bookEntity->getTitle());
        $stmt->bindValue(':explainText', $bookEntity->getExplainText());
        $stmt->bindValue(':picture', $bookEntity->getPicture());

        try {
            $stmt->execute();
        } catch (Exception $e) {
            return $e->getCode();
        }

        return $stmt->errorCode();
    }

    /**
     * 書籍エンティティを引数から取得し、その書籍をDBから削除する。
     * @param BookEntity $bookEntity 削除する書籍。
     * @return string 成功時なら00000のエラーコード。失敗時ならそれぞれの場合に対応したエラーコード。
     */
    public function deleteBook(BookEntity $bookEntity): string
    {
        $sql = 'delete from book where id = :id;';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $bookEntity->getId());
        $stmt->execute();

        return $stmt->errorCode();
    }
}
