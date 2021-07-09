/**
 * 経歴を管理するオブジェクト。
 * CRUD操作を行う。
 */
Career = (function () {
    const API_URL = '../../Backend/Api/CareerApi.php'

    /**
     * 経歴を作成する。
     * 作成する経歴のデータは引数より取得する。
     * @param FormData _form 経歴の作成に使用するフォームデータ。
     */
    function create_career(_form) {
        Utility.fetch_post('create', API_URL, _form)
    }

    /**
     * 経歴を取得する。
     */
    function read_career() {
        return fetch(API_URL)
    }

    /**
     * 経歴を更新する。
     * 更新する経歴のデータは引数より取得する。
     * @param FormData _form 経歴の更新に使用するフォームデータ。
     */
    function update_career(_form) {
        Utility.fetch_post('update', API_URL, _form)
    }

    /**
     * 引数のIDに合致した経歴を削除する。
     * @param FormData _form 経歴の削除に使用するフォームデータ。
     */
    function delete_career(_form) {
        Utility.fetch_post('delete', API_URL, _form)
    }

    return {
        create_career: create_career,
        read_career: read_career,
        update_career: update_career,
        delete_career: delete_career
    }
})()