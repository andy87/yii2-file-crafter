<?php

namespace andy87\yii2\file_crafter\test\events;

use Yii;
use yii\base\InvalidConfigException;
use andy87\yii2\file_crafter\test\UnitTestCore;
use andy87\yii2\file_crafter\components\{ models\Schema, events\CrafterEventRender };

/**
 * @cli vendor/bin/phpunit tests/events/CrafterEventRenderTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\test\events
 *
 * @tag: #test #event #crafter_event_render
 */
class CrafterEventRenderTest extends UnitTestCore
{
    /**
     * @cli vendor/bin/phpunit tests/events/CrafterEventRenderTest.php --testdox --filter testCrafterEventRender
     *
     * @throws InvalidConfigException
     */
    public function testCrafterEventRender(): void
    {
        $event = Yii::createObject(CrafterEventRender::class);

        $this->assertEquals('beforeRender', $event::BEFORE);

        $this->assertEquals('afterRender', $event::AFTER);

        $dataSchema = [
            'name' => 'Test One',
            'table_name' => 'test_one',
        ];

        $schema = new Schema();

        $schema->name = $dataSchema['name'];
        $schema->table_name = $dataSchema['table_name'];

        $event->schema = $schema;

        $listPath = [
            'sourcePath' => 'test',
            'generatePath' => 'test',
        ];

        $event->sourcePath = $listPath['sourcePath'];
        $event->generatePath = $listPath['generatePath'];

        $listReplace = [
            'test' => 'test',
        ];

        $event->replaceList = $listReplace;

        $event->content = 'test';

        $this->assertInstanceof(Schema::class, $event->schema);

        $this->assertEquals($event->schema->name, $dataSchema['name']);
        $this->assertEquals($event->schema->table_name, $dataSchema['table_name']);
    }
}