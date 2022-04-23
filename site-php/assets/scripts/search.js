const inPageSearchResultContainer = document.querySelector('[data-search-result-in-page]')
const defaultSearchResultContainer = document.querySelector('[data-search-result]')
const resultContainer = inPageSearchResultContainer || defaultSearchResultContainer
const searchBar = document.querySelector('[data-searchbar]')
const resultItemTemplate = document.querySelector('[data-item-result-template]')
let items = undefined
let noResultNodeAppend = false

// Settings
const WEBTOON_API_ENDPOINT = '/src/handlers/api/webtoons.php'
const WEBTOON_BASE_IMAGES_FOLDER = '/assets/webtoons-imgs/'

// Si on est sur une page affichant les résultats par défaut, on charge automatiquement les données
if (inPageSearchResultContainer) load().then(() => {
}, () => {
    const el = document.createElement('p')
    el.style.position = 'absolute'
    el.textContent = 'Erreur lors du chargement des webtoons. Vérifiez que vous êtes bien connecté à internet.'
    inPageSearchResultContainer.appendChild(el)
    inPageSearchResultContainer.style.position = 'relative'
    inPageSearchResultContainer.style.maxWidth = '100vw'  // Evite l'overflow
})

// Fonction de recherche
searchBar.addEventListener('input', e => {
    let found = false
    clearItems()
    load().then(() => {
        const search = e.target.value.toLowerCase()
        items.forEach(item => {
            const isVisible = item.searchableField.includes(search)
            found = found || isVisible
            item.el.classList.toggle('hidden', !isVisible)
        })
        if (!found) noResult()
    }, () => alert('Erreur lors du chargement des webtoons. Vérifiez que vous êtes bien connecté à internet.'))
})
searchBar.addEventListener('focus', () => {
    load().then(
        () => {
        },
        () => alert('Erreur lors du chargement des webtoons. Vérifiez que vous êtes bien connecté à internet.')
    )
}, {once: true})

/**
 * Renvoie la chaine de caractères str avec une taille maximale de 20
 * @param str
 * @param length
 * @returns {null|string}
 */
function maxLength(str, length = 17) {
    if (str) return str.length > length ? str.substr(0, length) + '...' : str
    return null
}

/**
 * Charge les webtoons
 */
function load() {
    if (items) return
    return new Promise((successCb, failureCb) => {
        if (items === undefined) {
            console.log('[API]: Loading data...')
            fetch(WEBTOON_API_ENDPOINT)
                .then(res => res.json(), reason => failureCb(reason))
                .then(data => {
                    items = data.map(item => {
                        const el = resultItemTemplate.content.cloneNode(true).children[0]
                        const title = getFormattedTitle(item.title)
                        const searchableField = `${item.title}`.toLowerCase()
                        el.querySelector('img').src = WEBTOON_BASE_IMAGES_FOLDER + item.cover
                        el.querySelector('.webtoon-title').textContent = title
                        el.href = `/webtoon?id=${item.id}`
                        resultContainer.append(el)
                        return {title, el, searchableField}
                    })
                    console.log('[API]: Data loaded.')
                    successCb()
                }, reason => failureCb(reason))
        } else {
            successCb()
        }
    })
}

function getFormattedTitle(title) {
    if (inPageSearchResultContainer) return maxLength(title) || '...'
    return maxLength(title, 25) || '...'
}

function clearItems() {
    if (!noResultNodeAppend) return
    let node = resultContainer.querySelector('[data-search-not-found="true"]')
    resultContainer.removeChild(node)
    noResultNodeAppend = false
}

function noResult() {
    if (noResultNodeAppend) return
    let node = document.createElement('span')
    node.append(document.createTextNode('Aucun résultats pour la recherche.'))
    node.setAttribute('data-search-not-found', 'true')
    node.style.cssText = 'display: block; margin: 1rem;'
    resultContainer.append(node)
    noResultNodeAppend = true
}