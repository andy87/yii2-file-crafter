<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests;

use andy87\yii2\file_crafter\components\services\CacheService;
use andy87\yii2\file_crafter\components\services\producers\SchemaProducer;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/** Verifies that rejected renames and failed writes preserve saved schemas. */
class SchemaSaveTest extends ApplicationTestCore
{
    /** @return void Renaming to an occupied name preserves both files. */
    public function testRenameCannotReplaceExistingSchema(): void
    {
        $alpha = $this->saveSchema('Alpha');
        $beta = $this->saveSchema('Beta');
        $original = [file_get_contents($alpha), file_get_contents($beta)];
        $this->setRequest(['name' => 'Beta'], ['update' => 'alpha']);

        $crafter = $this->createCrafter();

        $this->assertTrue($crafter->panelResources->schema->hasErrors('name'));
        $this->assertSame($original, [file_get_contents($alpha), file_get_contents($beta)]);
    }

    /** @return void Failed JSON encoding must not remove either version. */
    public function testFailedRenamePreservesOriginal(): void
    {
        $alpha = $this->saveSchema('Alpha');
        $original = file_get_contents($alpha);
        $this->setRequest(['name' => 'Gamma', 'custom_fields' => ['label' => "\xB1"]], ['update' => 'alpha']);

        $crafter = $this->createCrafter(['custom_fields' => ['label' => 'Label']]);

        $this->assertFileExists($alpha);
        $this->assertSame($original, file_get_contents($alpha));
        $this->assertFileDoesNotExist((new CacheService())->constructPath('gamma'));
        $this->assertTrue($crafter->panelResources->schema->hasErrors());
    }

    /** @return void A successful rename writes the replacement before deleting the old file. */
    public function testRenameToUnusedNameSucceeds(): void
    {
        $alpha = $this->saveSchema('Alpha');
        $this->setRequest(['name' => 'Gamma'], ['update' => 'alpha']);
        $this->createCrafter();

        $this->assertFileDoesNotExist($alpha);
        $this->assertSame('Gamma', json_decode((new CacheService())->getContentCacheFile('gamma'), true)['name']);
    }

    /** @return void A failed update leaves the old bytes intact. */
    public function testFailedUpdatePreservesOriginal(): void
    {
        $path = $this->saveSchema('Alpha');
        $original = file_get_contents($path);
        $schema = (new SchemaProducer(['label']))->create(['name' => 'Alpha', 'custom_fields' => ['label' => "\xB1"]]);

        $this->assertFalse($schema->save($path));
        $this->assertSame($original, file_get_contents($path));
    }

    /** @return void New writes cannot overwrite files created after validation. */
    public function testExclusiveSaveRefusesExistingFile(): void
    {
        $path = $this->saveSchema('Alpha');
        $original = file_get_contents($path);
        $schema = (new SchemaProducer([]))->create(['name' => 'Replacement']);

        $this->assertFalse($schema->save($path, false));
        $this->assertSame($original, file_get_contents($path));
    }

    /** @return void Editing a schema without renaming still replaces its content. */
    public function testUpdateWithoutRenameSucceeds(): void
    {
        $path = $this->saveSchema('Alpha');
        $this->setRequest(['name' => 'Alpha', 'custom_fields' => ['label' => 'Updated']], ['update' => 'alpha']);
        $crafter = $this->createCrafter(['custom_fields' => ['label' => 'Label']]);

        $this->assertFalse($crafter->panelResources->schema->hasErrors());
        $this->assertSame('Updated', json_decode(file_get_contents($path), true)['custom_fields']['label']);
    }

    /**
     * Seed a schema through the production save method.
     * @param string $name Schema display name.
     * @return string Path of the saved JSON file.
     */
    private function saveSchema(string $name): string
    {
        $this->createCrafter();
        $schema = (new SchemaProducer([]))->create(['name' => $name]);
        $path = (new CacheService())->constructPath($schema->getTableName());
        $this->assertTrue($schema->save($path));

        return $path;
    }
}
