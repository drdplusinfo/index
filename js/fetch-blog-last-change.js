window.addEventListener('DOMContentLoaded', () => {
    getLastArticleInfo().then(lastArticleInfo => {
        const lastArticleDate = lastArticleInfo['last_article_date'];
        const blogLastChange = document.getElementById('blog').getElementsByClassName('date')[0];
        const dateOfLastChange = new Date(lastArticleDate);
        blogLastChange.textContent = dateOfLastChange.toLocaleDateString('cs');

        const lastArticleTitle = lastArticleInfo['last_article_title'];
        const blogTitle = document.getElementById('blog').getElementsByClassName('title')[0];
        blogTitle.textContent = lastArticleTitle;
    });
});

/**
 * @return {Promise<{string}>}
 */
async function getLastArticleInfo() {
    const lastArticleInfoJson = await httpGetJson('https://update.blog.draciodkaz.cz/last_article_info.php');
    return lastArticleInfoJson['data'];
}

/**
 * @param {string} url
 * @return {Promise<{object}>}
 */
function httpGetJson(url) {
    const request = new Request(url);
    return fetch(request)
        .then(response => response.json());
}