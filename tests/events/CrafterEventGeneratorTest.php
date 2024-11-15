<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\events;

use andy87\yii2\file_crafter\components\events\CrafterEventGenerate;
use andy87\yii2\file_crafter\tests\core\UnitTestCore;
use Yii;
use yii\base\InvalidConfigException;
use yii\gii\CodeFile;

/**
 * @cli vendor/bin/phpunit tests/events/CrafterEventGeneratorTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\tests\events
 *
 * @tag: #test #event #generate
 */
class CrafterEventGeneratorTest extends UnitTestCore
{
    /**
     * @cli vendor/bin/phpunit tests/events/CrafterEventGeneratorTest.php --testdox --filter testCrafterEventGenerate
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