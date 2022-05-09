const container = document.querySelector('[data-container]')
const urlParams = buildUrlParamsObj()

// Todo: Use preferred user language
const API_ENDPOINT = `/@api/translations-blocks?webtoon=${urlParams.id}&chapter=${urlParams.chapter || 1}&language=${urlParams.language || 'en'}`
// console.log('endpoint : ' + API_ENDPOINT)

const data = await loadData()
// console.log("data", data)

data.forEach(image => {
    loadImageAndTranslate(image)
})


function loadImageAndTranslate(image) {
    const path = '/assets/webtoons-imgs/' + image.image
    const fontSize = image['font-size']
    const blocks = image.blocks

    const imgContainer = document.createElement('div')
    imgContainer.classList.add('imageBlock')

    const el = document.createElement('img')
    el.classList.add('image')
    el.src = path
    el.alt = 'Webtoon image'

    blocks.forEach(block => {
        buildBlock(block, fontSize, imgContainer)
    })

    imgContainer.appendChild(el)
    container.appendChild(imgContainer)
}

function buildBlock(block, fontSize, cont) {
    console.log(block)
    const el = document.createElement('p')
    el.style.top = block.startY + 'px'
    el.style.right = block.endX + 'px'
    //el.style.bottom = block.endY + 'px'
    el.style.left = block.startX + 'px'
    el.style.fontSize = fontSize + 'px'
    el.textContent = block.translations[urlParams.language || 'en']
    cont.appendChild(el)
}

function loadData() {
    return fetch(API_ENDPOINT)
        .then(res => res.json())
        .then(data => {
            if (data.data === null) {
                const el = document.createElement('p')
                el.textContent = 'Erreur lors du chargement du contenu.'
                el.style.margin = '1rem'
                container.appendChild(el)
                console.error(data.errors.join(', '))
                throw new Error(data.errors)
            }
            if (data.data.length === 0) {
                const el = document.createElement('p')
                el.textContent = 'Le chapitre est vide.'
                el.style.margin = '1rem'
                container.appendChild(el)
                console.error('Le chapitre ne contient aucune donnée.')
                throw new Error('Le chapitre ne contient aucune donnée.')
            }

            // console.log(data)
            console.log('[API]: Data loaded.')
            return data.data
        })
}

function buildUrlParamsObj() {
    const url = location.search
        .substring(1)
        .split('&')
    let result = {}
    for (let i = 0; i < url.length; i++) {
        let param = url[i].split('=')
        if (param[0] === undefined || param[0] === '') continue
        result[param[0]] = param[1] === undefined ? true : param[1]
    }
    return result
}