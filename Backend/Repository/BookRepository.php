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
