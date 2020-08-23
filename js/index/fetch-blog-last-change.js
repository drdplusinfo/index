$(() => {
    getLastArticleInfo().then(lastArticleInfo => {
        const lastArticleDate = lastArticleInfo['last_article_date']
        const blogLastChange = document.getElementById('blog').getElementsByClassName('date')[0]
        const dateOfLastChange = new Date(lastArticleDate)
        blogLastChange.textContent = dateOfLastChange.toLocaleDateString('cs')

        const lastArticleTitle = lastArticleInfo['last_article_title']
        const blogTitle = document.getElementById('blog').getElementsByClassName('title')[0]
        blogTitle.textContent = lastArticleTitle

        const lastArticleUrl = lastArticleInfo['last_article_url']
        if (lastArticleUrl) {
            const blogLastArticleAnchor = document.getElementById('blog').getElementsByTagName('a')[0]
            blogLastArticleAnchor.href = lastArticleUrl
            const lastArticleImage = lastArticleInfo['last_article_image']
            if (lastArticleImage) {
                const blogBackgroundContainer = blogLastArticleAnchor.getElementsByClassName('item-background-image')[0]
                blogBackgroundContainer.style.backgroundImage = `url(${lastArticleImage})`
            }
        }
    })
})

/**
 * @return {Promise<{string}>}
 */
async function getLastArticleInfo() {
    const lastArticleInfoJson = await httpGetJson('https://update.blog.draciodkaz.cz/last_article_info.php')
    return lastArticleInfoJson['data']
}

/**
 * @param {string} url
 * @return {Promise<{object}>}
 */
function httpGetJson(url) {
    const request = new Request(url)
    return fetch(request)
        .then(response => response.json())
}