/**
 * メニューの一覧のオブジェクト。
 * メニューの表示とクリック時の動作などを定義する。
 * メニューには、自己紹介、転職事由、経歴紹介、参考書籍の4種類が存在する。
 */

Menu = (function () {
    /**
     * メニューのDOMを作成する。
     */
    function show() {
        create_menu()
        create_menu_user()
        create_menu_job_change()
        create_menu_career()
        create_menu_book()
    }

    /**
     * それぞれのメニューの親となるDOMを作成する。
     */
    function create_menu() {
        let menu = document.createElement('div')
        menu.id = 'root-menu'
        menu.className = 'left-fade_in'
        document.getElementById('root').appendChild(menu)
    }

    /**
     * 自己紹介のメニューのDOMを作成する。
     */
    function create_menu_user() {
        let user = document.createElement('div')
        user.id = 'root-menu-user'
        user.innerText = '自己紹介'
        user.onclick = function () {
            clear()
            ViewUser.show()
        }
        document.getElementById('root-menu').appendChild(user)
    }

    /**
     * 転職事由のメニューのDOMを作成する。
     */
    function create_menu_job_change() {
        let job_change = document.createElement('div')
        job_change.id = 'root-menu-job_change'
        job_change.innerText = '転職事由'
        job_change.onclick = function () {
            clear()
            ViewJobChange.show()
        }
        document.getElementById('root-menu').appendChild(job_change)
    }

    /**
     * 経歴紹介のメニューのDOMを作成する。
     */
    function create_menu_career() {
        let career = document.createElement('div')
        career.id = 'root-menu-career'
        career.innerText = '経歴紹介'
        career.onclick = function () {
            clear()
            ViewCareer.show()
        }
        document.getElementById('root-menu').appendChild(career)
    }

    /**
     * 参考書籍のメニューのDOMを作成する。
     */
    function create_menu_book() {
        let book = document.createElement('div')
        book.id = 'root-menu-book'
        book.innerText = '参考書籍'
        book.onclick = function () {
            clear()
            ViewBook.show()
        }
        document.getElementById('root-menu').appendChild(book)
    }

    /**
     * メニュークリック時に、表示されているコンテンツのDOMを削除する。
     */
    function clear() {
        if (document.getElementById('root-user')) {
            document.getElementById('root-user').remove()
        }

        if (document.getElementById('root-job_change')) {
            document.getElementById('root-job_change').remove()
        }

        if (document.getElementById('root-career')) {
            document.getElementById('root-career').remove()
        }

        if (document.getElementById('root-book')) {
            document.getElementById('root-book').remove()
        }

        if (document.getElementById('root-navigation')) {
            document.getElementById('root-navigation').remove()
        }
    }

    return {
        show: show
    }
})()

Menu.show()