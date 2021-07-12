/**
 * 作成ボタンが押下された際に転職を作成する。
 */
document.getElementById('root-job_change-table-create').onclick = function () {
    let form = new FormData()
    form.append('type', 'create')
    form.append('id', document.getElementById('root-job_change-table-create-id').innerText)
    form.append('userId', document.getElementById('root-job_change-table-create-user_id').innerText)
    form.append('reason', document.getElementById('root-job_change-table-create-reason').innerText)
    form.append('motivation', document.getElementById('root-job_change-table-create-motivation').innerText)
    form.append('experience', document.getElementById('root-job_change-table-create-experience').innerText)

    if (confirm('転職を作成してもよろしいですか？')) {
        JobChange.create_job_change(form)
    }
}

/**
 * 更新ボタンが押下された際に転職を更新する。
 */
for (let index in document.getElementsByClassName('root-job_change-table-update')) {
    document.getElementsByClassName('root-job_change-table-update')[index].onclick = update_job_change
}

function update_job_change(_event) {
    let index = /^.*-([0-9]*)$/.exec(_event.target.id)[1] // indexを取得。タグの末尾の数字を取得する。
    let form = new FormData()
    form.append('type', 'update')
    form.append('id', document.getElementById('root-job_change-table-id-' + index).innerText)
    form.append('userId', document.getElementById('root-job_change-table-user_id-' + index).innerText)
    form.append('reason', document.getElementById('root-job_change-table-reason-' + index).innerText)
    form.append('motivation', document.getElementById('root-job_change-table-motivation-' + index).innerText)
    form.append('experience', document.getElementById('root-job_change-table-experience-' + index).innerText)

    if (confirm('転職を更新してもよろしいですか？')) {
        JobChange.update_job_change(form)
    }
}

/**
 * 削除ボタンが押下された際に転職を削除する。
 */
for (let index in document.getElementsByClassName('root-job_change-table-delete')) {
    document.getElementsByClassName('root-job_change-table-delete')[index].onclick = delete_job_change
}

function delete_job_change(_event) {
    if (confirm('転職を削除してもよろしいですか？')) {
        let index = /^.*-([0-9]*)$/.exec(_event.target.id)[1] // indexを取得。タグの末尾の数字を取得する。
        let tag_id = 'root-job_change-table-id-' + index
        let form = new FormData()
        form.append('type', 'delete')
        form.append('id', document.getElementById(tag_id).innerText)
        JobChange.delete_job_change(id)
    }
}