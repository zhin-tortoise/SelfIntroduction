<?php

/**
 * 書籍アプリケーションへのアクセスを提供するAPI。
 * CRUD操作に対応している。
 * レスポンスはJSON形式で返る。
 */

require_once(dirname(__FILE__) . '/../Application/BookApplication.php');

header("Content-Type: application/json; charset=utf-8");
$bookApi = new BookApi();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['type'] === 'create') {
    // 作成の場合
    $errorCode = $bookApi->createBook($_POST);
    echo json_encode(['errorCode' => $errorCode]);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // 参照の場合
    $book = $bookApi->readBookFromUserId();
    echo json_encode($book);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['type'] === 'update') {
    // 更新の場合
    $errorCode = $bookApi->updateBook($_POST);
    echo json_encode(['errorCode' => $errorCode]);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['type'] === 'delete') {
    // 削除の場合
    $errorCode = $bookApi->deleteBook($_POST);
    echo json_encode(['errorCode' => $errorCode]);
}

class BookApi
{
    private BookApplication $bookApplication; // 書籍アプリケーション

    /**
     * 書籍アプリケーションを用意する。
     */
    public function __construct()
    {
        $this->bookApplication = new BookApplication();
    }

    /**
     * 書籍の作成を行う。
     * @return エラーコード。
     */
    public function createBook($post)
    {
        return $this->bookApplication->createBook($post);
    }

    /**
     * ユーザーIDを元に書籍を取得するメソッド。
     * ユーザーIDはセッションから取得される。
     */
    public function readBookFromUserId()
    {
        session_start();
        if (!array_key_exists('userId', $_SESSION)) {
            return [];
        }

        $bookEntities = $this->bookApplication->readBookFromUserId($_SESSION['userId']);
        $books = [];
        foreach ($bookEntities as $bookEntity) {
            $book['id'] = $bookEntity->getId();
            $book['title'] = $bookEntity->getTitle();
            $book['explainText'] = $bookEntity->getExplainText();
            $book['picture'] = $bookEntity->getPicture();

            $books[] = $book;
        }

        return $books;
    }

    /**
     * IDを元に書籍を更新するメソッド。
     * @return エラーコード。
     */
    public function updateBook($post)
    {
        return $this->bookApplication->updateBook($post);
    }

    /**
     * IDを元に書籍を削除するメソッド。
     * @return エラーコード。
     */
    public function deleteBook($post)
    {
        if (!array_key_exists('id', $post)) {
            return ['errorCode' => '99999'];
        }

        return $this->bookApplication->deleteBook($post);
    }
}
