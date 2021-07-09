/**
 * ユーザーを管理するオブジェクト。
 * CRUD操作を行う。
 */
User = (function () {
    const API_URL = '../../Backend/Api/UserApi.php'

    /**
     * ユーザーを作成する。
     * 作成するユーザーのデータは引数より取得する。
     * @param FormData _form ユーザーの作成に使用するフォームデータ。
     */
    function create_user(_form) {
        Utility.fetch_post('create', API_URL, _form)
    }

    /**
     * ユーザーを取得する。
     */
    function read_user() {
        return fetch(API_URL)
    }

    /**
     * ユーザーを更新する。
     * 更新するユーザーのデータは引数より取得する。
     * @param FormData _form ユーザーの更新に使用するフォームデータ。
     */
    function update_user(_form) {
        Utility.fetch_post('update', API_URL, _form)
    }

    /**
     * 引数のIDに合致したユーザーを削除する。
     * @param FormData _form ユーザーの削除に使用するフォームデータ。
     */
    function delete_user(_form) {
        Utility.fetch_post('delete', API_URL, _form)
    }

    return {
        create_user: create_user,
        read_user: read_user,
        update_user: update_user,
        delete_user: delete_user
    }
})()