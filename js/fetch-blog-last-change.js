window.addEventListener('DOMContentLoaded', () => {
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
                const blogBackgroundContainer = document.createElement('div')
                blogBackgroundContainer.style.position = 'absolute'
                blogBackgroundContainer.style.zIndex = '-1'
                blogBackgroundContainer.style.width = '100%'
                blogBackgroundContainer.style.height = '100%'
                blogBackgroundContainer.style.backgroundImage = `url(${lastArticleImage})`

                const blogLastArticleAnchorOnmouseleave = () => {
                    blogBackgroundContainer.style.filter = 'grayscale(100%)'
                    blogBackgroundContainer.style.opacity = '60%'
                }

                blogLastArticleAnchor.style.position = 'relative'
                blogLastArticleAnchor.style.backgroundImage = 'none'

                blogLastArticleAnchor.onmouseenter = () => {
                    blogBackgroundContainer.style.filter = 'none'
                    blogBackgroundContainer.style.opacity = '100%'
                }
                blogLastArticleAnchor.onmouseleave = blogLastArticleAnchorOnmouseleave;
                blogLastArticleAnchorOnmouseleave();

                blogLastArticleAnchor.prepend(blogBackgroundContainer)
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