/**
 * 転職を管理するオブジェクト。
 * CRUD操作を行う。
 */
JobChange = (function () {
    const API_URL = '../../Backend/Api/JobChangeApi.php'

    /**
     * 転職を作成する。
     * 作成する転職のデータは引数より取得する。
     * @param FormData _form 転職の作成に使用するフォームデータ。
     */
    function create_job_change(_form) {
        Utility.fetch_post('create', API_URL, _form)
    }

    /**
     * 転職を取得する。
     */
    function read_job_change() {
        return fetch(API_URL)
    }

    /**
     * 転職を更新する。
     * 更新する転職のデータは引数より取得する。
     * @param FormData _form 転職の更新に使用するフォームデータ。
     */
    function update_job_change(_form) {
        Utility.fetch_post('update', API_URL, _form)
    }

    /**
     * 引数のIDに合致した転職を削除する。
     * @param FormData _form 転職の削除に使用するフォームデータ。
     */
    function delete_job_change(_form) {
        Utility.fetch_post('delete', API_URL, _form)
    }

    return {
        create_job_change: create_job_change,
        read_job_change: read_job_change,
        update_job_change: update_job_change,
        delete_job_change: delete_job_change
    }
})()