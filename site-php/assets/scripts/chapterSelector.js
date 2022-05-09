const select = document.getElementById('chapter')
const langSelect = document.getElementById('lang')
const url = buildUrlParamsObj()

function handleChanges() {
    window.location = `/webtoon?id=${url.id}&chapter=${select.value}&language=${url.lang || 'fr'}`
}

function handleLangChange() {
    window.location = `/webtoon?id=${url.id}&chapter=${url.chapter || 1}&language=${langSelect.value}`
}