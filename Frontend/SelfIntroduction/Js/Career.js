/**
 * 経歴のオブジェクト。
 * 経歴の取得と表示を定義する。
 * 経歴には、概要、日付、説明が含まれる。
 */

ViewCareer = (function () {
    const CAREER_LENGTH_IN_PAGE = 3
    let career = null
    let selected_career = 0
    let head_career_in_page = 0

    /**
     * APIから経歴を取得し、DOMを作成する。
     */
    function show() {
        download_career()
    }

    /**
     * APIから経歴を取得し、DOMを作成する。
     */
    function download_career() {
        if (career == null) {
            Career.read_career()
                .then(response => response.json())
                .then(data => {
                    career = data
                    if (career.length === 0) { // 経歴が存在しない場合はDOMを作成しない。
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
        create_career()
        create_career_list()
        create_career_list_topArrow()
        create_career_list_overview()
        create_career_list_bottomArrow()
        create_career_detail()
        create_career_detail_overview()
        create_career_detail_date()
        create_career_detail_horizon()
        create_career_detail_explain()
    }

    /**
     * 経歴のDOMを作成する。
     */
    function create_career() {
        let career = document.createElement('div')
        career.id = 'root-career';
        document.getElementById('root').appendChild(career)
    }

    /**
     * 経歴のリストのDOMを作成する。
     */
    function create_career_list() {
        let list = document.createElement('div')
        list.id = 'root-career-list'
        list.className = 'bottom-fast-fade_in'
        document.getElementById('root-career').appendChild(list)
    }

    /**
     * 経歴のリストに上矢印のDOMを作成する。
     */
    function create_career_list_topArrow() {
        let top_arrow = document.createElement('img')
        top_arrow.id = 'root-career-list-top_arrow'
        top_arrow.src = '../../Picture/TopArrow.png'
        top_arrow.onclick = previous_page
        document.getElementById('root-career-list').appendChild(top_arrow)
    }

    /**
     * 経歴のリストに概要のDOMを作成する。
     */
    function create_career_list_overview() {
        let create_limit = career.length < CAREER_LENGTH_IN_PAGE ? career.length : CAREER_LENGTH_IN_PAGE
        for (let career_index = 0; career_index < create_limit; career_index++) {
            let overview = document.createElement('div')
            overview.id = 'root-career-list-overview' + (parseInt(career_index) + 1)
            overview.innerText = career[head_career_in_page + career_index].overview
            overview.onclick = change_selected_career
            document.getElementById('root-career-list').appendChild(overview)
        }
    }

    /**
     * 経歴のリストに下矢印のDOMを作成する。
     */
    function create_career_list_bottomArrow() {
        let bottom_arrow = document.createElement('img')
        bottom_arrow.id = 'root-career-list-bottom_arrow'
        bottom_arrow.src = '../../Picture/BottomArrow.png'
        bottom_arrow.onclick = next_page
        document.getElementById('root-career-list').appendChild(bottom_arrow)
    }

    /**
     * 経歴の詳細のDOMを作成する。
     */
    function create_career_detail() {
        let detail = document.createElement('div')
        detail.id = 'root-career-detail'
        detail.className = 'bottom-slow-fade_in'
        document.getElementById('root-career').appendChild(detail)
    }

    /**
     * 経歴の詳細に概要のDOMを作成する。
     */
    function create_career_detail_overview() {
        let overview = document.createElement('div')
        overview.id = 'root-career-detail-overview'
        overview.innerText = career[selected_career].overview
        document.getElementById('root-career-detail').appendChild(overview)
    }

    /**
     * 経歴の詳細に日付のDOMを作成する。
     */
    function create_career_detail_date() {
        let date = document.createElement('div')
        date.id = 'root-career-detail-date'
        date.innerText = career[selected_career].startDate.replace(/-/g, '/') + ' ~ ' + career[selected_career].finishDate.replace(/-/g, '/')
        document.getElementById('root-career-detail').appendChild(date)
    }

    /**
     * 経歴の詳細に水平線のDOMを作成する。
     */
    function create_career_detail_horizon() {
        let horizon = document.createElement('hr')
        horizon.id = 'root-career-detail-horizon'
        document.getElementById('root-career-detail').appendChild(horizon)
    }

    /**
     * 経歴の詳細に説明のDOMを作成する。
     */
    function create_career_detail_explain() {
        let explain = document.createElement('div')
        explain.id = 'root-career-detail-explain'
        explain.innerText = career[selected_career].explainText
        document.getElementById('root-career-detail').appendChild(explain)
    }

    /**
     * 経歴のリストを削除する。
     */
    function delete_career_list() {
        if (document.getElementById('root-career-list')) {
            document.getElementById('root-career-list').remove()
        }
    }

    /**
     * 経歴の詳細を削除する。
     */
    function delete_career_detail() {
        if (document.getElementById('root-career-detail')) {
            document.getElementById('root-career-detail').remove()
        }
    }

    /**
     * 表示する経歴の詳細を変更する。
     */
    function change_selected_career(_event) {
        let index = /^.*overview([0-9]*)$/.exec(_event.target.id)[1] // indexを取得。タグの末尾の数字を取得する。
        selected_career = parseInt(head_career_in_page) + parseInt(index) - 1
        delete_career_detail()
        create_career_detail()
        create_career_detail_overview()
        create_career_detail_date()
        create_career_detail_horizon()
        create_career_detail_explain()
    }

    /**
     * 経歴のリストに表示する内容を前に戻す。
     */
    function previous_page() {
        head_career_in_page -= CAREER_LENGTH_IN_PAGE
        if (head_career_in_page < 0) {
            head_career_in_page = 0
        }

        delete_career_list()
        create_career_list()
        create_career_list_topArrow()
        create_career_list_overview()
        create_career_list_bottomArrow()
    }

    /**
     * 経歴のリストに表示する内容を先に進める。
     */
    function next_page() {
        head_career_in_page += CAREER_LENGTH_IN_PAGE
        if (head_career_in_page + CAREER_LENGTH_IN_PAGE > career.length) { // 表示する経歴が存在する経歴を超えてしまった場合
            head_career_in_page = career.length - CAREER_LENGTH_IN_PAGE
        }
        if (head_career_in_page < 0) {
            head_career_in_page = 0
        }

        delete_career_list()
        create_career_list()
        create_career_list_topArrow()
        create_career_list_overview()
        create_career_list_bottomArrow()
    }

    return {
        show: show
    }
})()