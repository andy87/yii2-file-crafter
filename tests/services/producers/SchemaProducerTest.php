<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\services\producers;

use andy87\yii2\file_crafter\components\models\Schema;
use andy87\yii2\file_crafter\components\services\producers\SchemaProducer;
use Yii;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/**
 * @cli vendor/bin/phpunit tests/services/producers/SchemaProducerTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\tests\services\producers
 *
 * @tag: #test #service #producer #schema_producer
 */
class SchemaProducerTest extends ApplicationTestCore
{
    /** @var array  */
    private const CUSTOM_FIELDS = [
        'test' => 'test',
        'test2' => 'test2',
    ];

    /**
     * @cli vendor/bin/phpunit tests/services/producers/SchemaProducerTest.php --testdox --filter testSchemaProducerCreate
     *
     * @return void
     */
    public function testSchemaProducerCreate(): void
    {
        $schemaProducer = new SchemaProducer(self::CUSTOM_FIELDS);

        $schema = $schemaProducer->create();

        $this->assertInstanceof(Schema::class, $schema);

        $this->assertEquals(array_keys($schema->custom_fields), array_keys(self::CUSTOM_FIELDS));

        $schema = $schemaProducer->create([
            Schema::NAME => 'Test Two',
        ]);

        $this->assertEquals('Test Two', $schema->name);
        $this->assertEquals('test_two', $schema->table_name);
    }

    /**
     * @cli vendor/bin/phpunit tests/services/producers/SchemaProducerTest.php --testdox --filter testSchemaProducerCreateParseDb
     *
     * @return void
     */
    public function testSchemaProducerCreateParseDb(): void
    {
        $schemaProducer = new SchemaProducer(self::CUSTOM_FIELDS);

        Yii::$app->db->createCommand('CREATE TABLE imported (id INTEGER NOT NULL, title VARCHAR(64))')->execute();
        $schema = $schemaProducer->createParseDb(['name' => 'Imported']);

        $this->assertEquals(Schema::SCENARIO_PARSE_DB, $schema->scenario);
        $this->assertSame(['id', 'title'], array_keys($schema->db_fields));
        $this->assertSame('', $schema->db_fields['title']->comment);
        $this->assertTrue($schema->db_fields['id']->notNull);
        $this->assertFalse($schema->db_fields['title']->notNull);
    }

    /** @return void Imported metadata retains actual table names and individual constraints. */
    public function testImportConstraintsAndPreview(): void
    {
        Yii::$app->db->createCommand('CREATE TABLE parent (id INTEGER PRIMARY KEY)')->execute();
        Yii::$app->db->createCommand('CREATE TABLE "CaseTable" (id INTEGER NOT NULL, title VARCHAR(64) UNIQUE, parent_id INTEGER REFERENCES parent(id), UNIQUE(id, parent_id))')->execute();
        $this->createCrafter();
        $schema = (new SchemaProducer([]))->createParseDb(['name' => 'Case Table', 'table_name' => 'CaseTable']);

        $this->assertSame('CaseTable', $schema->getTableName());
        $this->assertTrue($schema->db_fields['title']->unique);
        $this->assertFalse($schema->db_fields['id']->unique, 'A composite unique index does not make one column unique.');
        $this->assertTrue($schema->db_fields['parent_id']->foreignKeys);
        $this->assertFalse($schema->db_fields['title']->foreignKeys);
        $this->assertStringContainsString('Table name: CaseTable', $schema->getContent());

        $path = $this->testRoot . '/imported.json';
        $this->assertTrue($schema->save($path));
        $saved = json_decode(file_get_contents($path), true);
        $this->assertArrayNotHasKey('notNull', $saved['db_fields']['title']);
        $this->assertSame('checked', $saved['db_fields']['id']['notNull']);
    }

    /** @return void Missing tables produce a clear exception before accessing column metadata. */
    public function testMissingTableIsRejected(): void
    {
        $this->expectException(\yii\base\InvalidArgumentException::class);
        (new SchemaProducer([]))->createParseDb(['name' => 'Missing']);
    }
}
