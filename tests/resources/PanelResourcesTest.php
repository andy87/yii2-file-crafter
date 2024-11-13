<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\resources;

use andy87\yii2\file_crafter\components\models\Schema;
use andy87\yii2\file_crafter\components\resources\PanelResources;
use andy87\yii2\file_crafter\tests\core\UnitTestCore;

/**
 * @cli vendor/bin/phpunit tests/resources/PanelResourcesTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\tests\resources
 *
 * @tag: #test #resource #panel_resources
 */
class PanelResourcesTest extends UnitTestCore
{
    /**
     * @cli vendor/bin/phpunit tests/resources/PanelResourcesTest.php --testdox --filter testPanelResources
     *
     * @return void
     */
    public function testPanelResources(): void
    {
        $schema = new Schema();

        $listSchemaDto = [];
        $listSchemaDto[] = new Schema();
        $listSchemaDto[] = new Schema();

        $panelResources = new PanelResources($schema, $listSchemaDto);

        $this->assertInstanceof(Schema::class, $panelResources->schema);

        foreach ($panelResources->listSchemaDto as $schemaDto) {
            $this->assertInstanceof(Schema::class, $schemaDto);
        }
    }
}