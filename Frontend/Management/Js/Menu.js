/**
 * ユーザーを表示する。
 */
function display_user() {
    display_none()
    document.getElementById('root-user').style.display = 'inline'
}
document.getElementById('root-menu-user').onclick = display_user

/**
 * 転職を表示する。
 */
function display_job_change() {
    display_none()
    document.getElementById('root-job_change').style.display = 'inline'
}
document.getElementById('root-menu-job_change').onclick = display_job_change

/**
 * 経歴を表示する。
 */
function display_career() {
    display_none()
    document.getElementById('root-career').style.display = 'inline'
}
document.getElementById('root-menu-career').onclick = display_career

/**
 * 書籍を表示する。
 */
function display_book() {
    display_none()
    document.getElementById('root-book').style.display = 'inline'
}
document.getElementById('root-menu-book').onclick = display_book

/**
 * ユーザー、転職、経歴、書籍を非表示にする。
 */
function display_none() {
    document.getElementById('root-user').style.display = 'none'
    document.getElementById('root-job_change').style.display = 'none'
    document.getElementById('root-career').style.display = 'none'
    document.getElementById('root-book').style.display = 'none'
}

// 最初の画面にユーザーを表示する。
display_user()