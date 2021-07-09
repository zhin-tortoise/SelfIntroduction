/**
 * 複数のJSファイルから使用されるメソッドをまとめたライブラリ。
 */
Utility = (function () {
    /**
     * 引数で指定されたURLに対してPOSTを行う。
     * 引数で指定されたフォームを送信する。
     * @param string _type アラートに表示する文字を指定する。
     * @param string _api_url POSTを行うURL。APIを指定する。
     * @param FormData _form POSTで送信するフォームデータ。
     */
    function fetch_post(_type, _api_url, _form) {
        const METHOD = 'POST'
        const SUCCESS_CODE = '00000'
        const EMPTY_USER_ID_CODE = 'HY000'
        const NOT_EXISTS_USER_ID_CODE = '23000'
        const INCORRECT_DATE_TYPE_CODE = '22007'
        const EXISTS_MAIL_CODE = '99998'

        let type = select_type(_type)

        fetch(_api_url, {
                method: METHOD,
                body: _form
            })
            .then(response => response.json())
            .then(data => {
                let status_code = data.errorCode
                if (status_code === SUCCESS_CODE) {
                    alert(`${type}に成功しました。画面を更新してください。`)
                } else if (status_code === EMPTY_USER_ID_CODE) {
                    alert(`${type}に失敗しました。ユーザーIDを指定してください。`)
                } else if (status_code === NOT_EXISTS_USER_ID_CODE) {
                    alert(`${type}に失敗しました。存在するユーザーIDを指定してください。`)
                } else if (status_code === INCORRECT_DATE_TYPE_CODE) {
                    alert(`${type}に失敗しました。日付には年-月-日の形式で指定してください(例: 2021-06-10)。`)
                } else if (status_code === EXISTS_MAIL_CODE) {
                    alert(`${type}に失敗しました。既に存在するメールアドレスです。`)
                } else {
                    alert(`${type}に失敗しました。エラーコード : ${status_code}`)
                }
            })
    }

    /**
     * 引数から取得したタイプから、それに対応する文言を返す。
     * @param string _type create、update、deleteのいづれかを指定する。
     */
    function select_type(_type) {
        if (_type === 'create') {
            return '作成'
        } else if (_type === 'update') {
            return '更新'
        } else if (_type === 'delete') {
            return '削除'
        }
    }

    return {
        fetch_post: fetch_post
    }
})()