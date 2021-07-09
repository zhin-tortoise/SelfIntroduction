/**
 * 転職事由のオブジェクト。
 * 転職事由の取得と表示を定義する。
 * 転職事由には、転職理由、志望動機、活かせる経験が含まれる。
 */

ViewJobChange = (function () {
    let job_change = null

    /**
     * APIから転職事由を取得し、DOMを作成する。
     */
    function show() {
        download_job_change()
    }

    /**
     * APIから転職事由を取得し、DOMを作成する。
     */
    function download_job_change() {
        if (job_change == null) {
            JobChange.read_job_change()
                .then(response => response.json())
                .then(data => {
                    job_change = data
                    if (job_change.length === 0) {
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
        create_job_change()
        create_job_change_navigation()
        create_job_change_navigation_reason()
        create_job_change_navigation_motivation()
        create_job_change_navigation_experience()
        create_job_change_horizon()
        create_job_change_reason()
    }

    /**
     * 転職事由のDOMを作成する。
     */
    function create_job_change() {
        let job_change = document.createElement('div')
        job_change.id = 'root-job_change'
        document.getElementById('root').appendChild(job_change)
    }

    /**
     * 転職事由にナビゲーションのDOMを作成する。
     */
    function create_job_change_navigation() {
        let navigation = document.createElement('div')
        navigation.id = 'root-job_change-navigation'
        navigation.className = 'bottom-fast-fade_in'
        document.getElementById('root-job_change').appendChild(navigation)
    }

    /**
     * 転職事由のナビゲーションに転職理由のDOMを作成する。
     */
    function create_job_change_navigation_reason() {
        let reason = document.createElement('div')
        reason.id = 'root-job_change-navigation-reason'
        reason.innerText = '転職理由'
        reason.onclick = create_job_change_reason
        document.getElementById('root-job_change-navigation').appendChild(reason)
    }

    /**
     * 転職事由のナビゲーションに志望動機のDOMを作成する。
     */
    function create_job_change_navigation_motivation() {
        let motivation = document.createElement('div')
        motivation.id = 'root-job_change-navigation-motivation'
        motivation.innerText = '志望動機'
        motivation.onclick = create_job_change_motivation
        document.getElementById('root-job_change-navigation').appendChild(motivation)
    }

    /**
     * 転職事由のナビゲーションに活かせる経験のDOMを作成する。
     */
    function create_job_change_navigation_experience() {
        let experience = document.createElement('div')
        experience.id = 'root-job_change-navigation-experience'
        experience.innerText = '活かせる経験'
        experience.onclick = create_job_change_experience
        document.getElementById('root-job_change-navigation').appendChild(experience)
    }

    /**
     * 転職事由に水平線のDOMを作成する。
     */
    function create_job_change_horizon() {
        let horizon = document.createElement('hr')
        horizon.id = 'root-job_change-horizon'
        horizon.className = 'bottom-fast-fade_in'
        document.getElementById('root-job_change').appendChild(horizon)
    }

    /**
     * 転職事由に転職理由のDOMを作成する。
     */
    function create_job_change_reason() {
        clear()
        let reason = document.createElement('div')
        reason.id = 'root-job_change-reason'
        reason.className = 'root-job_change-detail bottom-slow-fade_in'
        reason.innerText = job_change.reason
        document.getElementById('root-job_change').appendChild(reason)
    }

    /**
     * 転職事由に志望動機のDOMを作成する。
     */
    function create_job_change_motivation() {
        clear()
        let motivation = document.createElement('div')
        motivation.id = 'root-job_change-motivation'
        motivation.className = 'root-job_change-detail bottom-slow-fade_in'
        motivation.innerText = job_change.motivation
        document.getElementById('root-job_change').appendChild(motivation)
    }

    /**
     * 転職事由に活かせる経験のDOMを作成する。
     */
    function create_job_change_experience() {
        clear()
        let experience = document.createElement('div')
        experience.id = 'root-job_change-experience'
        experience.className = 'root-job_change-detail bottom-slow-fade_in'
        experience.innerText = job_change.experience
        document.getElementById('root-job_change').appendChild(experience)
    }

    /**
     * 転職理由、志望動機、活かせる経験の削除
     */
    function clear() {
        if (document.getElementById('root-job_change-reason')) {
            document.getElementById('root-job_change-reason').remove()
        }

        if (document.getElementById('root-job_change-motivation')) {
            document.getElementById('root-job_change-motivation').remove()
        }

        if (document.getElementById('root-job_change-experience')) {
            document.getElementById('root-job_change-experience').remove()
        }
    }

    return {
        show: show
    }
})()