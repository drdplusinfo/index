<?php declare(strict_types=1);

namespace DrdPlus\Tests\Index;

use DrdPlus\Tests\RulesSkeleton\Partials\AbstractContentTest;

class FetchingBlogLastChangeTest extends AbstractContentTest
{
    /**
     * @test
     */
    public function I_can_fetch_blog_last_change()
    {
        $jsFile = __DIR__ . '/../../../js/fetch-blog-last-change.js';
        self::assertFileExists($jsFile, 'JS file with logic to fetch last blog change does not exist');
        $jsContent = file_get_contents($jsFile);
        self::assertIsString($jsContent);
        self::assertGreaterThan(0, strlen($jsContent));
        $matchesCount = preg_match('~(?<url>https://.+[.]php)~', $jsContent, $matches);
        self::assertSame(1, $matchesCount, 'No URL found in content ' . $jsFile);
        $urlToUpdateLastChange = $matches['url'];
        $content = $this->fetchContentFromUrl($urlToUpdateLastChange, self::WITH_BODY);
        self::assertSame('', $content['error'], 'Something goes wrong when fetching ' . $urlToUpdateLastChange);
        self::assertSame(200, $content['responseHttpCode']);
        $jsonContent = json_decode($content['content'], true);
        self::assertIsArray($jsonContent['data']);
        $data = $jsonContent['data'];
        $lastArticleDateString = $data['last_article_date'];
        self::assertRegExp('~20\d{2}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+]\d{2}:\d{2}~', $lastArticleDateString);
        $lastArticleDate = \DateTime::createFromFormat(DATE_ATOM, $lastArticleDateString);
        self::assertLessThan(new \DateTime(), $lastArticleDate);
        $lastArticleTitle = $data['last_article_title'];
        self::assertNotEmpty($lastArticleTitle);
        $lastArticleUrl = $data['last_article_url'];
        self::assertSame($lastArticleUrl, filter_var($lastArticleUrl, FILTER_VALIDATE_URL));
    }
}
