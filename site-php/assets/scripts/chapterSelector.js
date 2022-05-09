const select = document.getElementById('chapter')
const url = buildUrlParamsObj()

function handleChanges() {
    window.location = `/webtoon?id=${url.id}&chapter=${select.value}&language=${url.lang || 'fr'}`
}