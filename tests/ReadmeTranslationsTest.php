<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests;

use Symfony\Component\DomCrawler\Crawler;
use yii\helpers\Markdown;
use andy87\yii2\file_crafter\tests\core\UnitTestCore;

/** Keeps translated guides complete and their executable examples consistent with the English source. */
class ReadmeTranslationsTest extends UnitTestCore
{
    /** @return void Every translation preserves examples, section identifiers and working navigation. */
    public function testTranslationsPreserveExamplesSectionsAndLinks(): void
    {
        $root = dirname(__DIR__);
        $source = file_get_contents($root . '/README.md');
        preg_match_all('/^```[^\n]*\n.*?^```[ \t]*$/ms', $source, $sourceExamples);
        preg_match_all('/<span id="([^"]+)"><\/span>/', $source, $sourceIds);
        preg_match_all('/^#{2,3} /m', $source, $sourceHeadings);
        $sourceDocument = new Crawler(Markdown::process($source, 'gfm'));
        $languages = ['ru', 'zh-CN', 'pt-BR', 'es', 'ja', 'kk', 'fr', 'de'];
        foreach ($languages as $language) {
            $path = $root . '/docs/i18n/README.' . $language . '.md';
            $this->assertFileExists($path);
            $text = file_get_contents($path);
            $this->assertStringNotContainsString('ZXQ', $text, $language);
            preg_match_all('/^```[^\n]*\n.*?^```[ \t]*$/ms', $text, $examples);
            $this->assertSame($sourceExamples[0], $examples[0], $language . ': code examples changed');
            preg_match_all('/<span id="([^"]+)"><\/span>/', $text, $ids);
            $this->assertSame($sourceIds[1], $ids[1], $language . ': missing or reordered sections');
            $this->assertSame($ids[1], array_values(array_unique($ids[1])), $language . ': duplicate anchors');
            preg_match_all('/^#{2,3} /m', $text, $headings);
            $this->assertCount(count($sourceHeadings[0]), $headings[0], $language . ': missing headings');
            $document = new Crawler(Markdown::process($text, 'gfm'));
            $this->assertCount(count($sourceHeadings[0]), $document->filterXPath('//h2|//h3'), $language . ': broken heading rendering');
            $hrefs = [];
            foreach ($document->filterXPath('//a[@href]') as $link) {
                $href = $link->getAttribute('href');
                $hrefs[] = $href;
                if (str_starts_with($href, '#')) {
                    $this->assertContains(substr($href, 1), $ids[1], $language . ': ' . $href);
                } elseif (!preg_match('~^(?:[a-z][a-z0-9+.-]*:|//)~i', $href)) {
                    $this->assertFileExists(dirname($path) . '/' . $href, $language . ': ' . $href);
                }
            }
            foreach ($sourceDocument->filterXPath('//a[@href]') as $link) {
                $href = $link->getAttribute('href');
                if (str_starts_with($href, '#') || preg_match('~^https?://~', $href)) {
                    $this->assertContains($href, $hrefs, $language . ': missing source link');
                }
            }
            foreach ($languages as $target) $this->assertContains('README.' . $target . '.md', $hrefs);
            $this->assertContains('../../README.md', $hrefs);
        }
    }
}
