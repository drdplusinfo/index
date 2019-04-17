window.addEventListener('DOMContentLoaded', () => {
    getLastArticleDate().then(lastArticleDate => {
        const blogLastChange = document.getElementById('blog').getElementsByClassName('last-change')[0];
        const dateOfLastChange = new Date(lastArticleDate);
        blogLastChange.textContent = dateOfLastChange.toLocaleDateString('cs');
    });
});

/**
 * @return {Promise<{string}>}
 */
async function getLastArticleDate() {
    const lastArticleDateJson = await httpGet('http://blog.drdplus.loc/last_article_date.php');
    return lastArticleDateJson['last_article_date'];
}

/**
 * @param {string} theUrl
 * @return {Promise<{object}>}
 */
function httpGet(theUrl) {
    const request = new Request(theUrl);
    return fetch(request)
        .then(response => response.json());
}