<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests;

use Yii;
use yii\widgets\ActiveForm;
use andy87\yii2\file_crafter\components\services\producers\SchemaProducer;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/**
 * Renders stored values in real views and verifies that they remain text.
 *
 * @package andy87\yii2\file_crafter\tests
 */
class ViewSecurityTest extends ApplicationTestCore
{
    private const PAYLOAD = '\'"><img src=x onerror="window.fileCrafterAudit=1">';

    /** @return void Both the schema list and decoded popover content are safe. */
    public function testCacheAndPopoverEncodeStoredValues(): void
    {
        $crafter = $this->createCrafter();
        $schema = (new SchemaProducer([]))->create([
            'name' => self::PAYLOAD,
            'custom_fields' => ['label' => self::PAYLOAD],
        ]);
        $crafter->panelResources->listSchemaDto = [$schema];
        $html = Yii::$app->view->renderFile('@vendor/andy87/yii2-file-crafter/src/views/_cache.php', ['generator' => $crafter]);
        $xpath = $this->parseHtml($html);

        $this->assertSame(0, $xpath->query('//img|//script|//*[@onerror]')->length);
        $popover = $xpath->query('//*[@data-content]')->item(0)->getAttribute('data-content');
        $this->assertSame(0, $this->parseHtml($popover)->query('//img|//script|//*[@onerror]')->length);
        $this->assertStringContainsString(self::PAYLOAD, $xpath->document->textContent);
    }

    /** @return void Form inputs preserve quotes without creating new attributes. */
    public function testFormEncodesAttributesAndCheckboxValues(): void
    {
        $crafter = $this->createCrafter(['custom_fields' => ['label' => 'Label']]);
        $crafter->panelResources->schema = (new SchemaProducer(['label']))->create([
            'name' => 'Example',
            'custom_fields' => ['label' => self::PAYLOAD],
            'db_fields' => ['title' => [
                'name' => self::PAYLOAD,
                'comment' => self::PAYLOAD,
                'type' => 'string',
                'size' => '64',
                'unique' => 'checked onerror="window.fileCrafterAudit=1"',
            ]],
        ]);
        $form = new ActiveForm(['enableClientScript' => false, 'action' => '/gii/fileCrafter']);
        try {
            $html = Yii::$app->view->renderFile('@vendor/andy87/yii2-file-crafter/src/views/_form.php', ['generator' => $crafter, 'form' => $form]);
        } finally {
            $form->run();
        }
        $xpath = $this->parseHtml($html);

        $this->assertSame(0, $xpath->query('//img|//script|//*[@onerror]')->length);
        $input = $xpath->query('//input[@name="custom_fields[label]"]')->item(0);
        $this->assertSame(self::PAYLOAD, $input->getAttribute('value'));
    }

    /**
     * Parse HTML without executing script or suppressing assertion failures.
     *
     * @param string $html Rendered view or decoded popover markup.
     * @return \DOMXPath XPath queries for the resulting document.
     */
    private function parseHtml(string $html): \DOMXPath
    {
        $previous = libxml_use_internal_errors(true);
        $document = new \DOMDocument();
        $document->loadHTML($html);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        return new \DOMXPath($document);
    }
}
