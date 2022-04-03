const inPageSearchResultContainer = document.querySelector('[data-search-result-in-page]')
const defaultSearchResultContainer = document.querySelector('[data-search-result]')
const resultContainer = inPageSearchResultContainer || defaultSearchResultContainer
const searchBar = document.querySelector('[data-searchbar]')
const resultItemTemplate = document.querySelector('[data-item-result-template]')
let items = undefined
let noResultNodeAppend = false

// Si on est sur une page affichant les résultats par défaut, on charge automatiquement les données
if (inPageSearchResultContainer) load().then(() => {})

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
// Todo: Load data with focus within on searchBar

/**
 * Renvoie la chaine de caractères str avec une taille maximale de 20
 * @param str
 * @returns {null|string}
 */
function maxLength(str) {
    if (str) return str.length > 20 ? str.substr(0, 20) + '...' : str
    return null
}

/**
 * Charge les webtoons
 */
function load() {
    return new Promise((successCb, failureCb) => {
        if (items === undefined) {
            console.log('[API]: Loading data...')
            fetch('https://api.unsplash.com/photos/random?count=30&content_filter=low&query=manga&client_id=RgNusp6pAi-K2pSfEEluyP7agvOtMfgK6dL4HVpJLdw')
                .then(res => res.json(), reason => failureCb(reason))
                .then(data => {
                    data.slice(2, 100)
                    items = data.map(item => {
                        const el = resultItemTemplate.content.cloneNode(true).children[0]
                        const title = maxLength(item.description) || maxLength(item.alt_description) || '...'
                        const searchableField = `${item.description} ${item.alt_description}`.toLowerCase()
                        el.querySelector('img').src = item.urls.small
                        el.querySelector('.webtoon-title').textContent = title
                        resultContainer.append(el)
                        return {title, el, searchableField}
                    })
                    console.log('[API]: Data loaded.')
                    successCb()
                }, reason => failureCb(reason))
        } else { successCb() }
    })
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