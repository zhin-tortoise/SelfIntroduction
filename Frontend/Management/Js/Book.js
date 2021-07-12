/**
 * 作成ボタンが押下された際に書籍を作成する。
 */
document.getElementById('root-book-table-create').onclick = function () {
    let form = new FormData()
    form.append('type', 'create')
    form.append('id', document.getElementById('root-book-table-create-id').innerText)
    form.append('userId', document.getElementById('root-book-table-create-user_id').innerText)
    form.append('title', document.getElementById('root-book-table-create-title').innerText)
    form.append('explainText', document.getElementById('root-book-table-create-explain').innerText)
    form.append('picture', document.getElementById('root-book-table-create-picture').innerText)

    if (confirm('書籍を作成してもよろしいですか？')) {
        Book.create_book(form)
    }
}

/**
 * 更新ボタンが押下された際に書籍を更新する。
 */
for (let index in document.getElementsByClassName('root-book-table-update')) {
    document.getElementsByClassName('root-book-table-update')[index].onclick = update_book
}

function update_book(_event) {
    let index = /^.*-([0-9]*)$/.exec(_event.target.id)[1] // indexを取得。タグの末尾の数字を取得する。
    let form = new FormData
    form.append('type', 'update')
    form.append('id', document.getElementById('root-book-table-id-' + index).innerText)
    form.append('userId', document.getElementById('root-book-table-user_id-' + index).innerText)
    form.append('title', document.getElementById('root-book-table-title-' + index).innerText)
    form.append('explainText', document.getElementById('root-book-table-explain-' + index).innerText)
    form.append('picture', document.getElementById('root-book-table-picture-' + index).innerText)

    if (confirm('書籍を更新してもよろしいですか？')) {
        Book.update_book(form)
    }
}

/**
 * 削除ボタンが押下された際に書籍を削除する。
 */
for (let index in document.getElementsByClassName('root-book-table-delete')) {
    document.getElementsByClassName('root-book-table-delete')[index].onclick = delete_book
}

function delete_book(_event) {
    if (confirm('書籍を削除してもよろしいですか？')) {
        let index = /^.*-([0-9]*)$/.exec(_event.target.id)[1] // indexを取得。タグの末尾の数字を取得する。
        let tag_id = 'root-book-table-id-' + index
        let form = new FormData()
        form.append('type', 'delete')
        form.append('id', document.getElementById(tag_id).innerText)
        Book.delete_book(form)
    }
}