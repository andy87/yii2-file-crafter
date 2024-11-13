<?php

namespace andy87\yii2\file_crafter\test\events;

use Yii;
use yii\gii\CodeFile;
use yii\base\InvalidConfigException;
use andy87\yii2\file_crafter\test\UnitTestCore;
use andy87\yii2\file_crafter\components\events\CrafterEventGenerate;

/**
 * @cli vendor/bin/phpunit tests/events/CrafterEventGenerateTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\test\events
 *
 * @tag: #test #event #generate
 */
class CrafterEventGeneratorTest extends UnitTestCore
{
    /**
     * @cli vendor/bin/phpunit tests/events/CrafterEventGenerateTest.php --testdox --filter testCrafterEventGenerate
     *
     * @throws InvalidConfigException
     */
    public function testCrafterEventGenerator(): void
    {
        $event = Yii::createObject(CrafterEventGenerate::class);

        $this->assertEquals('beforeGenerate', $event::BEFORE);

        $this->assertEquals('afterGenerate', $event::AFTER);


        $dataCodeFile = [
            'path' => 'test',
            'content' => 'test',
        ];

        $codeFile = new CodeFile($dataCodeFile['path'], $dataCodeFile['content']);
        $event->files[] = $codeFile;

        $this->assertIsArray($event->files);

        $this->assertInstanceof(CodeFile::class, $event->files[0]);
    }
}