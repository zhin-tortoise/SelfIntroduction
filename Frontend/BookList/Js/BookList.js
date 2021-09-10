// 画像クリック時の操作
(function () {
    let picture = document.getElementsByClassName('root-book-row-picture')
    for (let index in picture) {
        picture[index].onclick = function (event) {
            let index = /^.*-([0-9]*)$/.exec(event.target.id)[1]
            createDom(index)
        }
    }
}())

// DOMの作成
function createDom(index) {
    let div = document.createElement('div')
    div.id = 'root-detail'
    div.appendChild(createBackground())
    div.appendChild(createPicture(index))
    div.appendChild(createTitle(index))
    div.appendChild(createExplainText(index))
    div.appendChild(createCancelButton())

    document.getElementById('root').appendChild(div)
}

// 背景の作成
function createBackground() {
    let background = document.createElement('div')
    background.id = 'root-detail-background'

    return background
}

// 画像のDOMの作成
function createPicture(index) {
    let img = document.createElement('img');
    img.className = 'root-detail-picture'
    img.src = document.getElementById(`root-book-row-picture-${index}`).src

    return img
}

// 題名のDOMの作成
function createTitle(index) {
    let title = document.createElement('p')
    title.className = 'root-detail-title'
    title.innerText = document.getElementById(`root-book-row-title-${index}`).innerText

    return title
}

// 説明のDOMの作成
function createExplainText(index) {
    let explainText = document.createElement('p')
    explainText.className = 'root-detail-explainText'
    explainText.innerText = document.getElementById(`root-book-row-explain-${index}`).innerText

    return explainText
}

// キャンセルボタンの作成
function createCancelButton() {
    let button = document.createElement('div')
    button.className = 'root-detail-cancel'
    button.innerText = '×'
    button.onclick = function () {
        document.getElementById('root-detail').remove()
    }

    return button
}