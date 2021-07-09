/**
 * 書籍のオブジェクト。
 * 書籍の取得と表示を定義する。
 * 書籍には、タイトル、写真、説明が含まれる。
 */

ViewBook = (function () {
    const BOOK_LENGTH_IN_PAGE = 5
    let book = null
    let selected_book = 0
    let head_book_in_page = 0

    /**
     * APIから書籍を取得し、DOMを作成する。
     */
    function show() {
        download_books()
    }

    /**
     * APIから書籍を取得し、DOMを作成する。
     */
    function download_books() {
        if (book == null) {
            Book.read_book()
                .then(response => response.json())
                .then(data => {
                    book = data
                    if (book.length === 0) {
                        return
                    }

                    create_dom()
                })
        } else {
            create_dom()
        }
    }

    /**
     * DOMを作成する。
     */
    function create_dom() {
        create_book()
        create_book_picture()
        create_book_title()
        create_book_horizon()
        create_book_explain()
        create_navigation()
        create_navigation_left_arrow()
        create_navigation_books()
        create_navigation_right_arrow()
    }

    /**
     * 書籍のDOMを作成する。
     */
    function create_book() {
        let book = document.createElement('div')
        book.id = 'root-book'
        book.className = 'bottom-slow-fade_in'
        document.getElementById('root').appendChild(book)
    }

    /**
     * 書籍に写真のDOMを作成する。
     */
    function create_book_picture() {
        let picture = document.createElement('img')
        picture.id = 'root-book-picture'
        picture.src = book[selected_book].picture
        document.getElementById('root-book').appendChild(picture)
    }

    /**
     * 書籍にタイトルのDOMを作成する。
     */
    function create_book_title() {
        let title = document.createElement('div')
        title.id = 'root-book-title'
        title.innerText = book[selected_book].title
        document.getElementById('root-book').appendChild(title)
    }

    /**
     * 書籍に水平線のDOMを作成する。
     */
    function create_book_horizon() {
        let horizon = document.createElement('hr')
        horizon.id = 'root-book-horizon'
        document.getElementById('root-book').appendChild(horizon)
    }

    /**
     * 書籍に説明のDOMを作成する。
     */
    function create_book_explain() {
        let explain = document.createElement('div')
        explain.id = 'root-book-explain'
        explain.innerText = book[selected_book].explainText
        document.getElementById('root-book').appendChild(explain)
    }

    /**
     * ナビゲーションのDOMを作成する。
     */
    function create_navigation() {
        let navigation = document.createElement('div')
        navigation.id = 'root-navigation'
        navigation.className = 'bottom-fast-fade_in'
        document.getElementById('root').appendChild(navigation)
    }

    /**
     * ナビゲーションに左矢印のDOMを作成する。
     */
    function create_navigation_left_arrow() {
        let left_arrow = document.createElement('img')
        left_arrow.id = 'root-navigation-leftArrow'
        left_arrow.className = 'root-navigation-arrow'
        left_arrow.src = '../../Picture/LeftArrow.png'
        left_arrow.onclick = back_page
        document.getElementById('root-navigation').appendChild(left_arrow)
    }

    /**
     * ナビゲーションに書籍のDOMを作成する。
     */
    function create_navigation_books() {
        index_limit = BOOK_LENGTH_IN_PAGE
        if (index_limit > book.length) {
            index_limit = book.length
        }

        for (let id = 0; id < index_limit; id++) {
            create_navigation_book(id)
        }
    }

    /**
     * ナビゲーションに書籍のDOMを作成する。
     */
    function create_navigation_book(_id) {
        let navigation_book = document.createElement('img')
        navigation_book.id = 'root-navigation-book' + (parseInt(_id) + 1)
        navigation_book.className = 'root-navigation-book'
        navigation_book.src = book[head_book_in_page + _id].picture
        navigation_book.onclick = change_selected_book
        document.getElementById('root-navigation').appendChild(navigation_book)
    }

    /**
     * ナビゲーションに右矢印のDOMを作成する。
     */
    function create_navigation_right_arrow() {
        let right_arrow = document.createElement('img')
        right_arrow.id = 'root-navigation-rightArrow'
        right_arrow.className = 'root-navigation-arrow'
        right_arrow.src = '../../Picture/RightArrow.png'
        right_arrow.onclick = next_page
        document.getElementById('root-navigation').appendChild(right_arrow)
    }

    /**
     * 書籍を削除する。
     */
    function delete_book() {
        if (document.getElementById('root-book')) {
            document.getElementById('root-book').remove()
        }
    }

    /**
     * ナビゲーションを削除する。
     */
    function delete_navigation() {
        if (document.getElementById('root-navigation')) {
            document.getElementById('root-navigation').remove()
        }
    }

    /**
     * 表示する本を変更する。
     */
    function change_selected_book(_event) {
        let index = /^.*book([0-9]*)$/.exec(_event.target.id)[1] // indexを取得。タグの末尾の数字を取得する。
        selected_book = parseInt(head_book_in_page) + parseInt(index) - 1
        delete_book()
        create_book()
        create_book_picture()
        create_book_title()
        create_book_horizon()
        create_book_explain()
    }

    /**
     * ナビゲーションを前に戻す。
     */
    function back_page() {
        head_book_in_page -= BOOK_LENGTH_IN_PAGE
        if (head_book_in_page < 0) {
            head_book_in_page = 0
        }

        delete_navigation()
        create_navigation()
        create_navigation_left_arrow()
        create_navigation_books()
        create_navigation_right_arrow()
    }

    /**
     * ナビゲーションを先に進める。
     */
    function next_page() {
        head_book_in_page += BOOK_LENGTH_IN_PAGE
        if (head_book_in_page + BOOK_LENGTH_IN_PAGE > book.length) { // 表示する書籍が存在する書籍を超えてしまった場合
            head_book_in_page = book.length - BOOK_LENGTH_IN_PAGE
        }
        if (head_book_in_page < 0) {
            head_book_in_page = 0
        }

        delete_navigation()
        create_navigation()
        create_navigation_left_arrow()
        create_navigation_books()
        create_navigation_right_arrow()
    }

    return {
        show: show
    }
})()