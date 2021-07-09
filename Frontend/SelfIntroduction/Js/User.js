/**
 * ユーザーのオブジェクト。
 * ユーザーの取得と表示を定義する。
 * ユーザーには、写真、氏名、生年月日、性別、学歴/職歴、資格、自己PRが含まれる。
 */

ViewUser = (function () {
    let user = null

    /**
     * APIからユーザーを取得し、DOMを作成する。
     */
    function show() {
        download_user()
    }

    /**
     * APIからユーザーを取得し、DOMを作成する。
     */
    function download_user() {
        if (user == null) {
            User.read_user()
                .then(response => response.json())
                .then(data => {
                    user = data
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
        create_user()
        create_user_picture()
        create_user_name()
        create_user_birthday()
        create_user_gender()
        create_user_horizon_top_navigation()
        create_user_navigation()
        create_user_navigation_background()
        create_user_navigation_qualification()
        create_user_navigation_profile()
        create_user_horizon_bottom_navigation()
        create_user_background()
    }

    /**
     * ユーザーのDOMを作成する。
     */
    function create_user() {
        let user = document.createElement('div')
        user.id = 'root-user'
        user.className = 'bottom-slow-fade_in'
        document.getElementById('root').appendChild(user)
    }

    /**
     * ユーザーに写真のDOMを作成する。
     */
    function create_user_picture() {
        let picture = document.createElement('img')
        picture.id = 'root-user-picture'
        picture.src = user.picture
        document.getElementById('root-user').appendChild(picture)
    }

    /**
     * ユーザーに氏名のDOMを作成する。
     */
    function create_user_name() {
        let name = document.createElement('div')
        name.id = 'root-user-name'
        name.innerText = `氏名 : ${user.name}`
        document.getElementById('root-user').appendChild(name)
    }

    /**
     * ユーザーに生年月日のDOMを作成する。
     */
    function create_user_birthday() {
        let birthday = document.createElement('div')
        birthday.id = 'root-user-birthday'
        birthday.innerText = `生年月日 : ${user.birthday.replace(/-/g, '/')}`
        document.getElementById('root-user').appendChild(birthday)
    }

    /**
     * ユーザーに性別のDOMを作成する。
     */
    function create_user_gender() {
        let gender = document.createElement('div')
        gender.id = 'root-user-gender'
        gender.innerText = `性別 : ${user.gender}`
        document.getElementById('root-user').appendChild(gender)
    }

    /**
     * ユーザーに水平線のDOMを作成する。
     */
    function create_user_horizon_top_navigation() {
        let horizon = document.createElement('hr')
        horizon.id = 'root-user-horizon_top_navigation'
        document.getElementById('root-user').appendChild(horizon)
    }

    /**
     * ユーザーにナビゲーションのDOMを作成する。
     */
    function create_user_navigation() {
        let navigation = document.createElement('div')
        navigation.id = 'root-user-navigation'
        document.getElementById('root-user').appendChild(navigation)
    }

    /**
     * ユーザーのナビゲーションに学歴/職歴のDOMを作成する。
     */
    function create_user_navigation_background() {
        let background = document.createElement('div')
        background.id = 'root-user-navigation-background'
        background.innerText = '学歴/職歴'
        background.onclick = create_user_background
        document.getElementById('root-user-navigation').appendChild(background)
    }

    /**
     * ユーザーのナビゲーションに資格のDOMを作成する。
     */
    function create_user_navigation_qualification() {
        let qualification = document.createElement('div')
        qualification.id = 'root-user-navigation-qualification'
        qualification.innerText = '資格'
        qualification.onclick = create_user_qualification
        document.getElementById('root-user-navigation').appendChild(qualification)
    }

    /**
     * ユーザーのナビゲーションに自己PRのDOMを作成する。
     */
    function create_user_navigation_profile() {
        let profile = document.createElement('div')
        profile.id = 'root-user-navigation-profile'
        profile.innerText = '自己PR'
        profile.onclick = create_user_profile
        document.getElementById('root-user-navigation').appendChild(profile)
    }

    /**
     * ユーザーに水平線のDOMを作成する。
     */
    function create_user_horizon_bottom_navigation() {
        let horizon = document.createElement('hr')
        horizon.id = 'root-user-horizon_bottom_navigation'
        document.getElementById('root-user').appendChild(horizon)
    }

    /**
     * ユーザーに学歴/職歴のDOMを作成する。
     */
    function create_user_background() {
        clear()
        let background = document.createElement('div')
        background.id = 'root-user-background'
        background.className = 'root-user-detail bottom-slow-fade_in'
        background.innerText = user.background
        document.getElementById('root-user').appendChild(background)
    }

    /**
     * ユーザーに資格のDOMを作成する。
     */
    function create_user_qualification() {
        clear()
        let qualification = document.createElement('div')
        qualification.id = 'root-user-qualification'
        qualification.className = 'root-user-detail bottom-slow-fade_in'
        qualification.innerText = user.qualification
        document.getElementById('root-user').appendChild(qualification)
    }

    /**
     * ユーザーに自己PRのDOMを作成する。
     */
    function create_user_profile() {
        clear()
        let profile = document.createElement('div')
        profile.id = 'root-user-profile'
        profile.className = 'root-user-detail bottom-slow-fade_in'
        profile.innerText = user.profile
        document.getElementById('root-user').appendChild(profile)
    }

    /**
     * 学歴/職歴、資格、自己PRの削除
     */
    function clear() {
        if (document.getElementById('root-user-background')) {
            document.getElementById('root-user-background').remove()
        }

        if (document.getElementById('root-user-qualification')) {
            document.getElementById('root-user-qualification').remove()
        }

        if (document.getElementById('root-user-profile')) {
            document.getElementById('root-user-profile').remove()
        }
    }

    return {
        show: show
    }
})()

ViewUser.show()