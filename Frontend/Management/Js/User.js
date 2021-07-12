/**
 * 作成ボタンが押下された際にユーザーを作成する。
 */
document.getElementById('root-user-table-create').onclick = function () {
    let form = new FormData()
    form.append('type', 'create')
    form.append('id', document.getElementById('root-user-table-create-id').innerText)
    form.append('name', document.getElementById('root-user-table-create-name').innerText)
    form.append('mail', document.getElementById('root-user-table-create-mail').innerText)
    form.append('password', document.getElementById('root-user-table-create-password').innerText)
    form.append('picture', document.getElementById('root-user-table-create-picture').innerText)
    form.append('birthday', document.getElementById('root-user-table-create-birthday').innerText)
    form.append('gender', document.getElementById('root-user-table-create-gender').innerText)
    form.append('background', document.getElementById('root-user-table-create-background').innerText)
    form.append('qualification', document.getElementById('root-user-table-create-qualification').innerText)
    form.append('profile', document.getElementById('root-user-table-create-profile').innerText)

    if (confirm('ユーザーを作成してもよろしいですか？')) {
        User.create_user(form)
    }
}

/**
 * 更新ボタンが押下された際にユーザーを更新する。
 */
for (let index in document.getElementsByClassName('root-user-table-update')) {
    document.getElementsByClassName('root-user-table-update')[index].onclick = update_user
}

function update_user(_event) {
    let index = /^.*-([0-9]*)$/.exec(_event.target.id)[1] // indexを取得。タグの末尾の数字を取得する。
    let form = new FormData()
    form.append('type', 'update')
    form.append('id', document.getElementById('root-user-table-id-' + index).innerText)
    form.append('name', document.getElementById('root-user-table-name-' + index).innerText)
    form.append('mail', document.getElementById('root-user-table-mail-' + index).innerText)
    form.append('password', document.getElementById('root-user-table-password-' + index).innerText)
    form.append('picture', document.getElementById('root-user-table-picture-' + index).innerText)
    form.append('birthday', document.getElementById('root-user-table-birthday-' + index).innerText)
    form.append('gender', document.getElementById('root-user-table-gender-' + index).innerText)
    form.append('background', document.getElementById('root-user-table-background-' + index).innerText)
    form.append('qualification', document.getElementById('root-user-table-qualification-' + index).innerText)
    form.append('profile', document.getElementById('root-user-table-profile-' + index).innerText)

    if (confirm('ユーザーを更新してもよろしいですか？')) {
        User.update_user(form)
    }
}

/**
 * 削除ボタンが押下された際にユーザーを削除する。
 */
for (let index in document.getElementsByClassName('root-user-table-delete')) {
    document.getElementsByClassName('root-user-table-delete')[index].onclick = delete_user
}

function delete_user(_event) {
    if (confirm('ユーザーを削除してもよろしいですか？')) {
        let index = /^.*-([0-9]*)$/.exec(_event.target.id)[1] // indexを取得。タグの末尾の数字を取得する。
        let tag_id = 'root-user-table-id-' + index
        let form = new FormData()
        form.append('type', 'delete')
        form.append('id', document.getElementById(tag_id).innerText)
        User.delete_user(form)
    }
}