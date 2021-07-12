/**
 * 作成ボタンが押下された際に経歴を作成する。
 */
document.getElementById('root-career-table-create').onclick = function () {
    let form = new FormData()
    form.append('type', 'create')
    form.append('id', document.getElementById('root-career-table-create-id').innerText)
    form.append('userId', document.getElementById('root-career-table-create-user_id').innerText)
    form.append('startDate', document.getElementById('root-career-table-create-start').innerText)
    form.append('finishDate', document.getElementById('root-career-table-create-finish').innerText)
    form.append('overview', document.getElementById('root-career-table-create-overview').innerText)
    form.append('explainText', document.getElementById('root-career-table-create-explain').innerText)

    if (confirm('経歴を作成してもよろしいですか？')) {
        Career.create_career(form)
    }
}

/**
 * 更新ボタンが押下された際に経歴を更新する。
 */
for (let index in document.getElementsByClassName('root-career-table-update')) {
    document.getElementsByClassName('root-career-table-update')[index].onclick = update_career
}

function update_career(_event) {
    let index = /^.*-([0-9]*)$/.exec(_event.target.id)[1] // indexを取得。タグの末尾の数字を取得する。
    let form = new FormData()
    form.append('type', 'update')
    form.append('id', document.getElementById('root-career-table-id-' + index).innerText)
    form.append('userId', document.getElementById('root-career-table-user_id-' + index).innerText)
    form.append('startDate', document.getElementById('root-career-table-start-' + index).innerText)
    form.append('finishDate', document.getElementById('root-career-table-finish-' + index).innerText)
    form.append('overview', document.getElementById('root-career-table-overview-' + index).innerText)
    form.append('explainText', document.getElementById('root-career-table-explain-' + index).innerText)

    if (confirm('経歴を更新してもよろしいですか？')) {
        Career.update_career(form)
    }
}

/**
 * 削除ボタンが押下された際に経歴を削除する。
 */
for (let index in document.getElementsByClassName('root-career-table-delete')) {
    document.getElementsByClassName('root-career-table-delete')[index].onclick = delete_career
}

function delete_career(_event) {
    if (confirm('経歴を削除してもよろしいですか？')) {
        let index = /^.*-([0-9]*)$/.exec(_event.target.id)[1] // indexを取得。タグの末尾の数字を取得する。
        let tag_id = 'root-career-table-id-' + index
        let form = new FormData()
        form.append('type', 'delete')
        form.append('id', document.getElementById(tag_id).innerText)
        Career.delete_career(form)
    }
}