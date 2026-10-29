<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests;

use Yii;
use yii\base\InvalidArgumentException;
use andy87\yii2\file_crafter\components\services\producers\SchemaProducer;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/** Loads generated PHP to verify that schema values stay data, never PHP syntax. */
class MigrationLiteralTest extends ApplicationTestCore
{
    /** @return void Quotes and template-like text survive PHP generation unchanged. */
    public function testColumnNamesAndCommentsArePhpLiterals(): void
    {
        $name = "owner's\\name";
        $comment = "Owner's name \\ {{label}}";
        $schema = (new SchemaProducer(['label']))->create([
            'name' => 'Literal example',
            'custom_fields' => ['label' => "don't interpolate"],
            'db_fields' => [
                $name => ['name' => $name, 'type' => 'string', 'size' => '', 'comment' => $comment],
                'count' => ['name' => 'count', 'type' => 'int', 'size' => '8'],
                'choice' => ['name' => 'choice', 'type' => 'enum', 'values' => ["owner's", 'other']],
                'choices' => ['name' => 'choices', 'type' => 'set', 'values' => ["owner's", 'other']],
                'data' => ['name' => 'data', 'type' => 'jsonb'],
            ],
        ]);
        $files = $this->createCrafter()->generate([$schema]);
        $path = $this->testRoot . '/' . basename($files[0]->path);
        file_put_contents($path, $files[0]->content);
        require $path;
        $class = pathinfo($path, PATHINFO_FILENAME);
        $migration = new $class(['db' => Yii::$app->db, 'compact' => true]);
        $method = new \ReflectionMethod($migration, 'columns');
        $columns = $method->invoke($migration);

        $this->assertArrayHasKey($name, $columns);
        $this->assertSame('string(255)', (string) $columns[$name]);
        $this->assertSame('integer(8)', (string) $columns['count']);
        $this->assertSame("enum('owner''s', 'other')", (string) $columns['choice']);
        $this->assertSame("set('owner''s', 'other')", (string) $columns['choices']);
        $this->assertSame('jsonb', (string) $columns['data']);
        $commentProperty = new \ReflectionProperty($columns[$name], 'comment');
        $this->assertSame($comment, $commentProperty->getValue($columns[$name]));
    }

    /** @return void Non-numeric sizes are rejected before a PHP file can be emitted. */
    public function testColumnSizeCannotInjectPhp(): void
    {
        $schema = (new SchemaProducer([]))->create([
            'name' => 'Invalid size',
            'db_fields' => ['title' => ['name' => 'title', 'type' => 'string', 'size' => '64); phpinfo(); //']],
        ]);
        $this->expectException(InvalidArgumentException::class);

        $this->createCrafter()->generate([$schema]);
    }
}
