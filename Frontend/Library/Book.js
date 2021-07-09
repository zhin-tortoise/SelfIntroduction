/**
 * 書籍を管理するオブジェクト。
 * CRUD操作を行う。
 */
Book = (function () {
    const API_URL = '../../Backend/Api/BookApi.php'

    /**
     * 書籍を作成する。
     * 作成する書籍のデータは引数より取得する。
     * @param FormData _form 書籍の作成に使用するフォームデータ。
     */
    function create_book(_form) {
        Utility.fetch_post('create', API_URL, _form)
    }

    /**
     * 書籍を取得する。
     */
    function read_book() {
        return fetch(API_URL)
    }

    /**
     * 書籍を更新する。
     * 更新する書籍のデータは引数より取得する。
     * @param FormData _form 書籍の更新に使用するフォームデータ。
     */
    function update_book(_form) {
        Utility.fetch_post('update', API_URL, _form)
    }

    /**
     * 引数のIDに合致した書籍を削除する。
     * @param FormData _form 書籍の削除に使用するフォームデータ。
     */
    function delete_book(_form) {
        Utility.fetch_post('delete', API_URL, _form)
    }

    return {
        create_book: create_book,
        read_book: read_book,
        update_book: update_book,
        delete_book: delete_book
    }
})()