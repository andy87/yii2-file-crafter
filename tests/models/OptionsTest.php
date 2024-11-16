<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\models;

use andy87\yii2\file_crafter\components\models\Options;
use andy87\yii2\file_crafter\tests\core\UnitTestCore;

/**
 * @cli vendor/bin/phpunit tests/models/OptionsTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\tests\models
 *
 * @tag: #test #model #options
 */
class OptionsTest extends UnitTestCore
{
    /** @var array  */
    private const DATA_OPTIONS = [
        'cache' => [
            'dir' => 'test1',
            'ext' => '.test2',
        ],
        'source' => [
            'dir' => 'test3',
            'ext' => '.test4',
        ],
        'commands' => ['test5 cmd'],
        'eventHandler' => 'test6',
        'custom_fields' => ['test7' => 'test8'],
        'autoCompleteStatus' => true,
        'autoCompleteList' => ['test9'],
        'previewStatus' => false,
        'canDelete' => false,
        'parseDataBase' => ['test10'],
        'templates' => [
            'group_1' => [
                'source' => 'target',
            ]
        ]
    ];



    /**
     * @cli vendor/bin/phpunit tests/models/OptionsTest.php --testdox --filter testOptions
     *
     * @return void
     */
    public function testOptions(): void
    {
        $options = new Options();

        $options->load(self::DATA_OPTIONS, '');

        $options->validate();

        foreach (self::DATA_OPTIONS as $key => $value) {
            $this->assertEquals($options->{$key}, $value , "Error in key: $key");
        }

        $this->assertEmpty($options->errors);
    }
}